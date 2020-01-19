<?php declare(strict_types=1);


namespace App\Validator;


use App\Exception\BizException;
use Swoft\Log\Helper\Log;
use Swoft\Redis\Redis;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class VerifyValidator
 * @package App\Validator
 * @since 2.0
 *
 * @Validator(name="VerifyValidator")
 */
class VerifyValidator implements ValidatorInterface
{
    /**
     * 验证码校核
     * @param array $data
     * @param array $params
     * @return array
     * @throws BizException
     * @throws ValidatorException
     */
    public function validate(array $data, array $params): array
    {
        if(!isset($data['captcha'])) {
            throw new ValidatorException('captcha must be exist');
        }
        if($data['captcha']!=Redis::get('captcha:'.$data[$params['receiver']].':'.$params['scene'])) {
            throw new BizException('',CAPTCHA_ERROR);
        }
        Redis::del('captcha:'.$data[$params['receiver']].':'.$params['scene']);
        return $data;
    }
}
