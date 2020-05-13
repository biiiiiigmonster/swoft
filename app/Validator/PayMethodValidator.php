<?php declare(strict_types=1);


namespace App\Validator;


use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\Required;

/**
 * Class PayMethodValidator
 * @package App\Validator
 * @Validator("payMethodValidator")
 */
class PayMethodValidator
{
    /**
     * @IsString()
     * @Enum(values={"scan","dynamic","js"},message="支付方式错误！")
     * @Required()
     *
     * @var string
     */
    protected $method;
}
