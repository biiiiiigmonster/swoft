<?php


namespace App\Rpc\Service;


use App\Rpc\Lib\EmailInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;
use think\helper\Str;

/**
 * Class EmailService
 * @package App\Rpc\Service
 * @since 2.0
 *
 * @Service()
 */
class EmailService implements EmailInterface
{
    /**
     * 发送验证码
     * @param string $email
     * @return array
     */
    public function sendCaptcha(string $email): array
    {
        $code = Str::random();
        return [
            'code' => $code,
            'email' => $email,
        ];
    }
}
