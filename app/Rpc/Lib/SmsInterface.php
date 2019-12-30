<?php


namespace App\Rpc\Lib;

/**
 * 短信服务
 * Interface SmsInterface
 * @package App\Rpc\Lib
 * @since 2.0
 */
interface SmsInterface
{
    /**
     * 发送短信
     * @param string $mobile
     *
     * @return array
     */
    public function sendCaptcha(string $mobile): array;
}
