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
use Swoft\Limiter\Annotation\Mapping\RateLimiter;
use Swoft\Log\Helper\CLog;
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
     * 发送验证码接口仅仅只是做了静态的参数验证，如果严格来讲还应该有动态验证，比如注册场景下的验证码发送，
     * 为了避免短信资源被消耗，发送前可以检测一下该账号是否已经注册，如果已经注册了，就阻断提示；
     * 这个动态验证暂时可以不做，不影响后续业务逻辑，只是资源消耗而已，不过要做的的话得单独写个场景验证器，
     * 比如某某情况下才不允许做什么，至于怎么去漂亮的实现，还需细品
     * @Validate(validator="CreateCaptchaValidator",fields={"type","scene","mobile"})
     * 这里限流器的作用就当做就是防抖吧，毕竟最小限制是1qps/seconds；PS：这个好像还不能使用
     * @RateLimiter(rate=1,key="request.post('mobile')~':'~request.post('scene')")
     *
     * @param Request $request
     * @return array
     */
    public function sendSms(Request $request): array
    {
        $param = $request->post();

        $res = $this->smsService->sendCaptcha($param['mobile']);
        Redis::set('captcha:'.$res['mobile'].':'.$param['scene'],$res['captcha'],config('captcha.expire'));
        return $res;
    }

    /**
     * 发送邮件验证码
     *
     * @RequestMapping(route="email", method=RequestMethod::POST)
     * @Validate(validator="CreateCaptchaValidator",fields={"type","scene","email"})
     * @RateLimiter(rate=1,key="request.post('email')~':'~request.post('scene')")
     *
     * @param Request $request
     * @return array
     */
    public function sendEmail(Request $request): array
    {
        $param = $request->post();

        $res = $this->emailService->sendCaptcha($param['email']);
        Redis::set('captcha:'.$res['email'].':'.$param['scene'],$res['captcha'],config('captcha.expire'));
        return $res;
    }
}
