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

use App\Rpc\Lib\UserInterface;
use Carbon\Carbon;
use OpenApi\Annotations\OpenApi;
use Swoft\Bean\BeanFactory;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Task\Task;

// use Swoft\Http\Message\Response;

/**
 * Class UserController
 *
 * @Controller(prefix="/auth")
 */
class IndexController{

    /**
     * 用户登录
     *
     * @RequestMapping(route="login", method=RequestMethod::POST)
     * @param Request $request
     * @return array
     * @throws \Swoft\Task\Exception\TaskException
     */
    public function login(Request $request): array
    {
        $data = $request->post();

        $user = BeanFactory::getBean('UserLogic')->login($data);
        //登陆成功之后的异步处理
        Task::async('LoginTask','imprint',[$user['id'],['last_login_ip'=>ip(),'last_login_time'=>Carbon::now()->toDateTimeString()]]);

        return $user;
    }
}
