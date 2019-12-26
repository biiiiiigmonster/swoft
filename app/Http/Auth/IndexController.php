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
use OpenApi\Annotations\OpenApi;
use Swoft\Bean\BeanFactory;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

// use Swoft\Http\Message\Response;

/**
 * Class UserController
 *
 * @Controller(prefix="/auth")
 * @package App\Http\Controller
 */
class IndexController{

    /**
     * 用户登录
     * @RequestMapping(route="login", method=RequestMethod::POST)
     * @param Request $request
     * @return array
     */
    public function login(Request $request): array
    {
        $data = $request->post();

        $user = BeanFactory::getBean('UserLogic')->login($data);

        return $user;
    }
}
