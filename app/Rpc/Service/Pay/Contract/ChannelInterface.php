<?php declare(strict_types=1);


namespace App\Rpc\Service\Pay\Contract;


interface ChannelInterface
{
    /**
     * 商户入住
     * @param array $data
     * @return array
     */
    public function entry(array $data): array;

    /**
     * 用户被扫 B扫C
     * @param array $data
     * @return array
     */
    public function scan(array $data): array;

    /**
     * 用户主扫 C扫B 二维码支付
     * @param array $data
     * @return array
     */
    public function dynamic(array $data): array;

    /**
     * C扫B --小程序，公众号，H5
     * @param array $data
     * @return array
     */
    public function js(array $data): array;

    /**
     * 退款
     * @param array $data
     * @return bool
     */
    public function refund(array $data): bool;
}
