<?php


namespace App\Validator;


use Swoft\Redis\Redis;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class AwaitValidator
 * @package App\Validator
 *
 * @Validator(name="AwaitValidator")
 */
class AwaitValidator implements ValidatorInterface
{
    /**
     * 验证socket是否连接
     * @param array $data
     * @param array $params
     * @return array
     * @throws ValidatorException
     */
    public function validate(array $data, array $params): array
    {
        //验证唯一凭据在redis中是否存在记录，通过后即代表可向该唯一凭据对应的fd推送消息   PS：唯一凭据策略后期应随需求而定
        if(!Redis::get($data[$params['key']])) {
            throw new ValidatorException('errors');
        }

        return $data;
    }
}