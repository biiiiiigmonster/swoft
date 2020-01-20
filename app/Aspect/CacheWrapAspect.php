<?php declare(strict_types=1);

namespace App\Aspect;

use App\Annotation\Mapping\CacheWrap;
use App\Annotation\Register\CacheWrapRegister;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Log\Helper\CLog;
use Throwable;

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
     * @throws Throwable
     */
    public function aroundAdvice(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $className = $proceedingJoinPoint->getClassName();
        $methodName = $proceedingJoinPoint->getMethod();
        $argsMap = $proceedingJoinPoint->getArgsMap();

        [$key, $ttl] = CacheWrapRegister::get($className,$methodName);
        $key = CacheWrapRegister::formatedKey($argsMap,$key);

        return remember($key,fn() => $proceedingJoinPoint->proceed(),(int)$ttl);
    }
}
