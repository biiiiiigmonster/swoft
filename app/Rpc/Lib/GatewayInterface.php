<?php declare(strict_types=1);


namespace App\Rpc\Lib;


use App\Rpc\Service\Pay\Contract\ChannelInterface;

interface GatewayInterface
{
    /**
     * 支付网关
     * @param string $method 支付方式
     * @param array $param 支付参数
     * @return array
     */
    public function pay(string $method,array $param): array;

    /**
     * 退款
     * @param array $param 退款参数
     * @return bool
     */
    public function refund(array $param): bool;

    /**
     * 商户进件
     * @param array $param 进件参数
     * @return array
     */
    public function entry(array $param): array;
}
