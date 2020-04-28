<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Auth;

use App\Event\UserEvent;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AuthorizeMiddleware;
use App\Model\Entity\User;
use App\Model\Logic\UserLogic;
use App\Rpc\Lib\UserInterface;
use BiiiiiigMonster\Cache\Cache;
use Carbon\Carbon;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Log\Helper\CLog;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Task\Task;
use Swoft\Validator\Annotation\Mapping\Validate;
use App\Exception\BizException;
use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\Exception\DbException;
use Swoft\Task\Exception\TaskException;
use Swoft\Validator\Annotation\Mapping\ValidateType;

/**
 * Class UserController
 *
 * @Controller(prefix="/auth")
 */
class UserController{
    /**
     * @Inject()
     *
     * @var UserLogic
     */
    private UserLogic $logic;

    /**
     * @Reference(pool="user.pool",version="1.2")
     *
     * @var UserInterface
     */
    private $userService;

    /**
     * 生成许可链接
     * @RequestMapping(route="license", method=RequestMethod::GET)
     * @param Request $request
     * @return array
     */
    public function license(Request $request): array
    {
        $uuid = $request->getHeaderLine('Terminal-Code');
        $url = $request->getUri()->getHost()."/auth/scan?uuid=$uuid";
        return ['url' => "https://$url"];
    }

    /**
     * app端扫码
     * @RequestMapping(route="scan", method=RequestMethod::GET)
     * @Middleware(AuthMiddleware::class)
     * @Validate(validator="WsPushValidator",type=ValidateType::GET,params={"key":"uuid"})
     * @param Request $request
     */
    public function scan(Request $request): void
    {
        //推送信息
        $uuid = $request->get('uuid');
        //触发用户扫码事件
        sgo(fn() => \Swoft::trigger(UserEvent::SCAN,User::find($request->auth->id),$request->get()));
        server()->push((int)Cache::get($uuid),ws_format('scan'));
    }

    /**
     * app端授权许可，将token发送至接收者
     * @RequestMapping(route="authorize", method=RequestMethod::GET)
     * @Middleware(AuthMiddleware::class)身份验证，前置
     * @Validate(validator="WsPushValidator",type=ValidateType::GET,params={"key":"uuid"})
     * @param Request $request
     */
    public function authorize(Request $request): void
    {
        $id = $request->auth->id;
        $iss = $request->getUri()->getHost();//签发者
        $aud = '*.'.root_domain($request);//接收者

        //生成授权
        $jwt = $this->userService->authorize(['id'=>$id],$iss,$aud);

        //推送授权信息
        $uuid = $request->get('uuid');
        server()->push((int)Cache::get($uuid),ws_format('authorize',"Bearer $jwt"));
    }

    /**
     * 用户登录
     *
     * @RequestMapping(route="login", method=RequestMethod::POST)
     * @Validate(validator="UserValidator",fields={"mobile","password"})静态参数验证
     * @Middleware(AuthorizeMiddleware::class)颁发授权token，后置操作
     *
     * @param Request $request
     * @return array
     * @throws BizException
     * @throws ReflectionException
     * @throws ContainerException
     * @throws DbException
     * @throws TaskException
     */
    public function login(Request $request): array
    {
        $data = $request->post();

        $user = $this->logic->login($data);
        /**
         * 关于事件处理机制与任务投递机制
         * 1、事件是同步执行策略（可以通过sgo创建协程方式达到异步效果），任务分别有三种执行策略（同步、协程、异步，详见文档）
         * 2、这两种方案均可用于解决业务逻辑分支问题
         * 3、事件触发属于被动型：在完成主线逻辑之后，只需要抛出触发标识，由监听（订阅）者负责捕获并实现就行；
         *      可以看作一对多关系（一处触发，多处实现）；
         *    任务投递属于主动型：业务逻辑中主动触发，将数据投递至预先设置好的方法队列中，让队列代为消费，一般采取协程或异步策略，提高性能；
         *      可以看作多对一关系（多处投递，一处实现）；
         * 4、为什么解释这些，因为这两种机制在简单情形下使用比较相似，比较容易让人无法选择，在初期使用或者年轻工作者容易随意使用，会造成隐患
         *    建议根据上面的解释，再结合实际业务场景，慎重选型，慎重coding！
         */
        //触发登录事件
        sgo(fn() => \Swoft::trigger(UserEvent::LOGIN,User::find($user['id'])));//异步触发
        //投递记录本次登录信息
        Task::async('LoginTask','imprint',[$user['id'],['last_login_ip'=>ip($request),'last_login_time'=>Carbon::now()->toDateTimeString()]]);

        return $user;
    }

    /**
     * 用户注册
     *
     * @RequestMapping(route="register", method=RequestMethod::POST)
     * @Validate(validator="UserValidator",fields={"mobile","password","passwordConf"})静态参数验证
     * @Validate(validator="MobileUniqueValidator")手机号user表唯一验证
     * @Validate(validator="VerifyValidator",params={"receiver":"mobile","scene":"register"})验证码注册场景验证
     * @Middleware(AuthorizeMiddleware::class)默认登陆成功，颁发授权token，后置操作
     *
     * @param Request $request
     * @return array
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public function register(Request $request): array
    {
        $data = $request->post();

        $user = $this->logic->register($data);
        //触发注册事件
        sgo(fn() => \Swoft::trigger(UserEvent::REGISTER,User::find($user['id'])));//异步触发

        return $user;
    }
}
