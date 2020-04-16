<?php


namespace App\Aspect;


use App\Annotation\Mapping\Throttle;
use App\Exception\ThrottleException;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;

/**
 * Class ThrottleWrapAspect
 * @package App\Aspect
 * @Aspect()
 * @PointAnnotation(
 *     include={Throttle::class}
 * )
 */
class ThrottleWrapAspect
{
    /**
     * @Before()
     * @throws ThrottleException
     */
    public function before()
    {
        throw new ThrottleException('请求太频繁了');
    }
}
