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

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AuthorizeMiddleware;
use App\Model\Logic\UserLogic;
use App\Rpc\Lib\UserInterface;
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
    private $logic;

    /**
     * @Reference(pool="user.pool",version="1.2")
     *
     * @var UserInterface
     */
    private $userService;

    /**
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
     * @Validate(validator="PushValidator",type=ValidateType::GET,params={"key":"uuid"})
     * @param Request $request
     */
    public function scan(Request $request): void
    {
        //推送信息
        $uuid = $request->get('uuid');
        server()->push((int)Redis::get($uuid),wsFormat('scan'));
    }

    /**
     * app端授权许可，将token发送至接收者
     * @RequestMapping(route="authorize", method=RequestMethod::GET)
     * @Middleware(AuthMiddleware::class)身份验证，前置
     * @Validate(validator="PushValidator",type=ValidateType::GET,params={"key":"uuid"})
     * @param Request $request
     */
    public function authorize(Request $request): void
    {
        $id = $request->auth->id;
        $iss = $request->getUri()->getHost();//签发者
        $aud = '*.'.rootDomain();//接收者

        //生成授权
        $jwt = $this->userService->authorize(['id'=>$id],$iss,$aud);

        //推送授权信息
        $uuid = $request->get('uuid');
        server()->push((int)Redis::get($uuid),wsFormat('authorize',"Bearer $jwt"));
    }

    /**
     * 用户登录
     *
     * @RequestMapping(route="login", method=RequestMethod::POST)
     * @Validate(validator="UserValidator",fields={"mobile","password"})静态参数验证
     * @Validate(validator="VerifyValidator",params={"receiver":"mobile","scene":"login"})验证码登录场景验证
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
        //投递记录本次登陆信息
        Task::async('LoginTask','imprint',[$user['id'],['last_login_ip'=>ip(),'last_login_time'=>Carbon::now()->toDateTimeString()]]);

        return $user;
    }

    /**
     * 用户注册
     *
     * @RequestMapping(route="register", method=RequestMethod::POST)
     * @Validate(validator="UserValidator",fields={"mobile","password","passwordConf"})静态参数验证
     * @Validate(validator="MobileUniqueValidator")手机号user表唯一验证
     * @Validate(validator="VerifyValidator",params={"receiver":"mobile","scene":"register"})验证码注册尝尽验证
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

        return $user;
    }
}
