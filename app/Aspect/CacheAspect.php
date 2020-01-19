<?php declare(strict_types=1);

namespace App\Aspect;

use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Annotation\Mapping\PointExecution;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Log\Helper\CLog;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class CacheAspect
 * @package App\Aspect
 *
 * @Aspect(order=1)
 *
 * @PointAnnotation(include={
 *      Validate::class
 *     })
 */
class CacheAspect
{
    /**
     * 环绕通知
     *
     * @Around()
     *
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws \Throwable
     */
    public function aroundAdvice(ProceedingJoinPoint $proceedingJoinPoint)
    {
        CLog::debug('aop进来了哟');
        $ret = $proceedingJoinPoint->proceed();
        CLog::debug('看看这是啥：'.json_encode($ret));
        return ['xixi'=>123];
    }
}
