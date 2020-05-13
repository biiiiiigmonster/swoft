<?php declare(strict_types=1);


namespace App\Rpc\Middleware;


use App\Rpc\Service\Pay\Contract\ChannelInterface;
use Swoft\Rpc\Server\Contract\MiddlewareInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Rpc\Server\Contract\RequestHandlerInterface;
use Swoft\Rpc\Server\Contract\RequestInterface;
use Swoft\Rpc\Server\Contract\ResponseInterface;
use Swoft\Rpc\Server\Exception\RpcServerException;

/**
 * Class ChannelMiddleware
 * @package App\Rpc\Middleware
 * @Bean()
 */
class ChannelMiddleware implements MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param RequestHandlerInterface $requestHandler
     * @return ResponseInterface
     * @throws RpcServerException
     */
    public function process(RequestInterface $request, RequestHandlerInterface $requestHandler): ResponseInterface
    {
        $channel = bean('duolabao');

        if(!$channel instanceof ChannelInterface) {
            throw new RpcServerException('没有获取到交易通道呀！');
        }
        $request->channel = $channel;
        return $requestHandler->handle($request);
    }
}
