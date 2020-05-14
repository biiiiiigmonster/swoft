<?php


namespace App\Rpc\Service;


use App\Rpc\Lib\EmailInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;
use Swoft\Stdlib\Helper\StringHelper;

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
     * @throws \Exception
     */
    public function sendCaptcha(string $email): array
    {
        $captcha = StringHelper::randomString('distinct',6);
        return [
            'captcha' => $captcha,
            'email' => $email,
        ];
    }
}
