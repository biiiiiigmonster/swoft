<?php declare(strict_types=1);


namespace App\Validator;


use App\Annotation\Mapping\MobileInternational;
use Swoft\Validator\Annotation\Mapping\Confirm;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
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
     * @MobileInternational(message="手机号格式不正确")
     *
     * @var string
     */
    protected $mobile;

    /**
     * @IsString()
     * @Length(min=8,max=16,message="密码长度需在8~16位之间")
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
    protected $passwordConf;
}
