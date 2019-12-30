<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Open;

use App\Rpc\Lib\EmailInterface;
use App\Rpc\Lib\SmsInterface;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Log\Helper\Log;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Exception;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class CaptchaController
 *
 * @Controller(prefix="/captcha")
 * @package App\Http\Open
 */
class CaptchaController{
    /**
     * @Reference(pool="sms.pool")
     *
     * @var SmsInterface
     */
    private $smsService;

    /**
     * @Reference(pool="email.pool")
     *
     * @var EmailInterface
     */
    private $emailService;

    /**
     * 发送短信验证码
     *
     * @RequestMapping(route="sms", method=RequestMethod::POST)
     * @Validate(validator="CreateCaptchaValidator",fields={"type","scene","mobile"})
     *
     * @param Request $request
     * @return array
     */
    public function sendSms(Request $request): array
    {
        $param = $request->post();

        $res = $this->smsService->sendCaptcha($param['mobile']);
        Redis::set('captcha:'.$res['mobile'].':'.$res['scene'],$res['code'],config('captcha.expire'));
        return $res;
    }

    /**
     * 发送邮件验证码
     *
     * @RequestMapping(route="email", method=RequestMethod::POST)
     * @Validate(validator="CreateCaptchaValidator",fields={"type","scene","email"})
     *
     * @param Request $request
     * @return array
     */
    public function sendEmail(Request $request): array
    {
        $param = $request->post();

        $res = $this->emailService->sendCaptcha($param['email']);
        Redis::set('captcha:'.$res['email'].':'.$res['scene'],$res['code'],config('captcha.expire'));
        return $res;
    }
}
