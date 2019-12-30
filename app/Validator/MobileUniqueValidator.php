<?php


namespace App\Validator;


use App\Model\Entity\User;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Exception\ValidatorException;

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
     * @throws ValidatorException
     */
    public function validate(array $data, array $params): array
    {
        if(User::where('mobile',$data['mobile'])->count()) {
            throw new ValidatorException('mobile already exists');
        }

        return $data;
    }
}
