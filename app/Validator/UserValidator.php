<?php declare(strict_types=1);


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\Confirm;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Max;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Mobile;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class UserValidator
 *
 * @since 2.0
 *
 * @Validator(name="UserValidator")
 */
class UserValidator
{
    /**
     * @IsString()
     * @Mobile(name="手机号格式不正确")
     *
     * @var string
     */
    protected $mobile;

    /**
     * @IsString()
     * @Max(value=16,message="密码长度不得大于16位")
     * @Min(value=8,message="密码长度不得小于8位")
     *
     * @var string
     */
    protected $password;

    /**
     * @IsString()
     * @Confirm(name="password",message="确认密码不一致")
     *
     * @var string
     */
    protected $password_conf;
}
