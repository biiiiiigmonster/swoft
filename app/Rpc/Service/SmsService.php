<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Rpc\Service;

use App\Rpc\Lib\SmsInterface;
use Swoft\Log\Helper\Log;
use Swoft\Rpc\Server\Annotation\Mapping\Service;
use Swoft\Stdlib\Helper\StringHelper;

/**
 * Class SmsService - This is an controller for handle rpc request
 *
 * @Service()
 */
class SmsService implements SmsInterface
{
    /**
     * 发送验证码
     * @param string $mobile
     * @return array
     * @throws \Exception
     */
    public function sendCaptcha(string $mobile): array
    {
        $captcha = StringHelper::randomString('distinct',6);
        return [
            'captcha' => $captcha,
            'mobile' => $mobile,
        ];
    }
}
