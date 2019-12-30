<?php


namespace App\Rpc\Lib;

/**
 * 邮件服务
 * Interface EmailInterface
 * @package App\Rpc\Lib
 * @since 2.0
 */
interface EmailInterface
{
    /**
     * 发送邮件
     * @param string $email
     *
     * @return array
     */
    public function sendCaptcha(string $email): array;
}
