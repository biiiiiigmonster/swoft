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
use Swoft\Aop\Annotation\Mapping\PointExecution;
use Swoft\Log\Helper\CLog;

/**
 * Class AnnotationAspect
 *
 * @since 2.0
 *
 * @PointExecution({
        "App\\Http\\Auth\\UserController::.*o.*"
 *     })
 */
class AnnotationAspect
{
    /**
     * @After()
     */
    public function after()
    {
        CLog::info('要出去了啊');
    }
}
