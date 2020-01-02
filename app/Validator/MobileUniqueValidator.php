<?php declare(strict_types=1);


namespace App\Validator;


use App\Exception\BizException;
use App\Model\Entity\User;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;

/**
 * Class MobileUniqueValidator
 * @package App\Validator
 * @since 2.0
 *
 * @Validator(name="MobileUniqueValidator")
 */
class MobileUniqueValidator implements ValidatorInterface
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     * @throws BizException
     */
    public function validate(array $data, array $params): array
    {
        if(User::where('mobile',$data['mobile'])->count()) {
            throw new BizException('手机号已存在',FAILED);
        }

        return $data;
    }
}
