<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Aspect;

use Swoft\Aop\Annotation\Mapping\After;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointExecution;
use Swoft\Log\Helper\CLog;

/**
 * Class AnnotationAspect
 *
 * @since 2.0
 *
 * @Aspect()
 *
 * PointExecution的注解参数格式为 {class::method} ，其中class与method均支持正则表达式匹配，如何匹配的可看具体代码实现
 * @PointExecution({
        "App\\Http\\Auth\\UserController::.*g.*"
 *     })
 */
class AnnotationAspect
{
    /**
     * @After()
     */
    public function after()
    {
//        CLog::info('要出去了啊');
    }
}
