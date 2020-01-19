<?php declare(strict_types=1);

namespace App\Aspect;

use App\Annotation\Mapping\CacheWrap;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Log\Helper\CLog;

/**
 * Class CacheWrapAspect
 * @package App\Aspect
 *
 * @Aspect(order=1)
 *
 * @PointAnnotation(include={
 *     CacheWrap::class
 * })
 */
class CacheWrapAspect
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
        $argsMap = $proceedingJoinPoint->getArgsMap();
        CLog::debug('参数吧：'.json_encode($argsMap));
        CLog::debug('看看这是啥：'.json_encode($ret));
        return ['xixi'=>123];
    }
}
