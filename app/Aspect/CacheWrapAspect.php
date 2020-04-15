<?php declare(strict_types=1);

namespace App\Aspect;

use App\Annotation\Mapping\CacheWrap;
use App\Register\CacheWrapRegister;
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
        if(!$key = CacheWrapRegister::formatKey($argsMap,$key)) {
            //如果没有从缓存注解中解析出有效key（因为CacheWrap注解key非必填），则采用默认规则来赋值key
            $key = "$className@$methodName";
        }

        return remember($key,fn() => $proceedingJoinPoint->proceed(),(int)$ttl);
    }
}
