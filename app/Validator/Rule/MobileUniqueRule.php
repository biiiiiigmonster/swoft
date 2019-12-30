<?php declare(strict_types=1);


namespace App\Validator\Rule;


use App\Annotation\Mapping\MobileUnique;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Validator\Contract\RuleInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class MobileUniqueRule
 *
 * @Bean(MobileUnique::class)
 */
class MobileUniqueRule implements RuleInterface
{
    /**
     * @param array $data
     * @param string $propertyName
     * @param object $item
     * @param null $default
     * @return array
     * @throws ValidatorException
     */
    public function validate(array $data, string $propertyName, $item, $default = null): array
    {
        $message = $item->getMessage();
        if (!isset($data[$propertyName]) && $default === null) {
            $message = (empty($message)) ? sprintf('%s must exist!', $propertyName) : $message;
            throw new ValidatorException($message);
        }

        //用户表中不存在记录即为判断通过
        if(!User::where('mobile',$data[$propertyName])->count()) {
            return [$data];
        }

        $message = (empty($message)) ? sprintf('%s must be a unique', $propertyName) : $message;
        throw new ValidatorException($message);
    }
}
