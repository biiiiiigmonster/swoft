<?php declare(strict_types=1);


namespace App\Validator\Rule;


use App\Annotation\Mapping\MobileInternational;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Log\Helper\Log;
use Swoft\Validator\Contract\RuleInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class MobileInternationalRule
 *
 * @Bean(MobileInternational::class)
 */
class MobileInternationalRule implements RuleInterface
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

        //手机号国际化验证，所有正则表达式均从.env配置文件中获取
        Log::info(config('regex.international_phone'));
        Log::info(json_encode($data));
        if(preg_match(config('regex.international_phone'), $data[$propertyName])) {
            return $data;
        }

        $message = (empty($message)) ? sprintf('%s must be a unique', $propertyName) : $message;
        throw new ValidatorException($message);
    }
}
