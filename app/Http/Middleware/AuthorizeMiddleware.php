<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Middleware;

use App\Rpc\Lib\UserInterface;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Log\Helper\CLog;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use function context;

/**
 * Class AuthorizeMiddleware - Custom middleware
 * @Bean()
 */
class AuthorizeMiddleware implements MiddlewareInterface
{
    /**
     * @Reference(pool="user.pool",version="1.2")
     *
     * @var UserInterface
     */
    private UserInterface $userService;

    /**
     * Process an incoming server request.
     *
     * @param ServerRequestInterface|Request  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $data = $response->getData();
        $iss = $request->getUri()->getHost();//签发者
        $aud = '*.'.root_domain($request);//接收者

        //授权动作调用与用户服务的授权
        $jwt = $this->userService->authorize(['id'=>$data['id']],$iss,$aud);
        return $response
            ->withHeader('Access-Control-Expose-Headers','Authorization')
            ->withHeader('Authorization',"Bearer $jwt");

        // after request handle
    }
}
