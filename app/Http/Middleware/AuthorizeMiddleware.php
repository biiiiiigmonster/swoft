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

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Log\Helper\CLog;
use function context;

/**
 * Class AuthorizeMiddleware - Custom middleware
 * @Bean()
 */
class AuthorizeMiddleware implements MiddlewareInterface
{
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
        $time = time();
        $data = $response->getData();
        $token = [
            'iat' => $time,//签发时间
            'nbf' => $time,//生效时间，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time + 3600*24*30,//过期时间
            "iss" => $request->getUri()->getHost(),//签发者
            'aud' => $request->getUri()->getScheme().'://*.'.rootDomain(),//接收者
            'data' => [//自定义信息，不要定义敏感信息
                'id' => $data['id'],//例如用户主键id
//                'mobile' => $data['mobile'],//用户手机号
                //等等...
            ],
        ];

        $jwt = JWT::encode($token, config('secret.jwt', 'CT5'),'HS256');
        $arr = JWT::decode($jwt,config('secret.jwt', 'CT5'),['HS256']);
        CLog::info($jwt);
        CLog::info(config('secret.jwt', 'CT5'));
        CLog::info(json_encode($arr));
        return $response
            ->withHeader('Access-Control-Expose-Headers','Authorization')
            ->withHeader('Authorization',"Bearer $jwt");

        // after request handle
    }
}
