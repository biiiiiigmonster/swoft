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
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Task\Task;
use Swoft\Validator\Annotation\Mapping\Validate;
use App\Exception\BizException;
use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\Exception\DbException;
use Swoft\Task\Exception\TaskException;

/**
 * Class UserController
 *
 * @Controller(prefix="/auth")
 */
class UserController{
    /**
     * @Inject("UserLogic")
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
        $url = $request->getUri()->getScheme().'://'.$request->getUri()->getHost().'/auth/scan/'.$uuid;
        return ['url' => $url];
    }

    /**
     * app端扫码
     * @RequestMapping(route="scan/{uuid}", method=RequestMethod::GET)
     * @Middleware(AuthMiddleware::class)
     * @param string $uuid
     */
    public function scan(string $uuid): void
    {

    }

    /**
     * app端授权许可，将token发送至接收者
     * @RequestMapping(route="authorize/{uuid}", method=RequestMethod::GET)
     * @Middleware(AuthMiddleware::class)
     * @param Request $request
     * @param string $uuid
     * @return array
     */
    public function authorize(Request $request,string $uuid): array
    {
        $id = $request->auth->id;
        $iss = $request->getUri()->getHost();//签发者
        $aud = '*.'.rootDomain();//接收者
        $jwt = $this->userService->authorize(['id'=>$id],$iss,$aud);
    }

    /**
     * 用户登录
     *
     * @RequestMapping(route="login", method=RequestMethod::POST)
     * @Validate(validator="UserValidator",fields={"mobile","password"})
     * @Middleware(AuthorizeMiddleware::class)
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
     * @Validate(validator="UserValidator",fields={"mobile","password","passwordConf"})
     * @Validate(validator="MobileUniqueValidator")
     * @Validate(validator="CaptchaValidator",params={"receiver":"mobile","scene":"register"})
     * @Middleware(AuthorizeMiddleware::class)
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
