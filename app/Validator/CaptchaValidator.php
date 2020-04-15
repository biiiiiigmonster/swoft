<?php declare(strict_types=1);


namespace App\Validator;


use App\Annotation\Mapping\MobileInternational;
use Swoft\Validator\Annotation\Mapping\Email;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class CreateCaptchaValidator
 * @package App\Validator
 * @since 2.0
 *
 * @Validator("CaptchaValidator")
 */
class CaptchaValidator
{
    /**
     * 验证码生成类型
     * @IsString()
     * @Enum(values={"IMG","SMS","EMAIL"})
     * @Required()
     * @var string
     */
    protected $type;

    /**
     * 验证码生成场景
     * @IsString()
     * @Required()
     * @var string
     */
    protected $scene;

    /**
     * 验证码生成接收-短信渠道
     * @IsString()
     * @MobileInternational()
     * @var string
     */
    protected $mobile;

    /**
     * 验证码生成接收-邮件渠道
     * @IsString()
     * @Email()
     * @var string
     */
    protected $email;
}
