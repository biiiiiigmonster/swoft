<?php declare(strict_types=1);


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\Date;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class OrderValidator
 * @package App\Validator
 *
 * @Validator(name="OrderValidator")
 */
class OrderValidator
{
    /**
     * 起始时间
     * @IsString()
     * @Date()
     * @Required()
     *
     * @var string
     */
    protected $start;

    /**
     * 结束时间
     * @IsString()
     * @Date()
     * @Required()
     *
     * @var string
     */
    protected $end;
}
