<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Rpc\Service\Pay;

use App\Rpc\Lib\GatewayInterface;
use App\Rpc\Middleware\ChannelMiddleware;
use App\Rpc\Service\Pay\Contract\ChannelInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Middleware;
use Swoft\Rpc\Server\Annotation\Mapping\Service;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class PayService - This is an controller for handle rpc request
 *
 * @Service()
 */
class GatewayService implements GatewayInterface
{
    /**
     * @inheritDoc
     * @Middleware(ChannelMiddleware::class)
     * @Validate(validator="payMethodValidator")
     *
     */
    public function pay(string $method,array $param): array
    {
        $res = context()->getRequest()->channel->{$method}($param);
        //下单成功

        return $res;
    }

    /**
     * @inheritDoc
     * @Middleware(ChannelMiddleware::class)
     */
    public function refund(array $param): bool
    {
        $res = context()->getRequest()->channel->refund($param);

        return $res;
    }

    /**
     * @inheritDoc
     */
    public function entry(array $param): array
    {
        /** @var ChannelInterface */
        $channel = bean('duolabao');

        $res = $channel->entry($param);

        return $res;
    }
}
