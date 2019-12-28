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

use App\Http\Middleware\AuthorizeMiddleware;
use App\Model\Logic\UserLogic;
use Carbon\Carbon;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Task\Task;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class UserController
 *
 * @Controller(prefix="/auth")
 */
class IndexController{
    /**
     * @Inject("UserLogic")
     *
     * @var UserLogic
     */
    private $logic;

    /**
     * 用户登录
     *
     * @RequestMapping(route="login", method=RequestMethod::POST)
     * @Validate(validator="UserValidator",fields={"mobile","password"})
     * @Middleware(AuthorizeMiddleware::class)
     *
     * @param Request $request
     * @return array
     * @throws \App\Exception\BizException
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Swoft\Task\Exception\TaskException
     */
    public function login(Request $request): array
    {
        $data = $request->post();

        $user = $this->logic->login($data);
        //登陆成功之后的异步处理
        Task::async('LoginTask','imprint',[$user['id'],['last_login_ip'=>ip(),'last_login_time'=>Carbon::now()->toDateTimeString()]]);

        return $user;
    }
}
