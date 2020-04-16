<?php


namespace App\Aspect;


use App\Annotation\Mapping\Throttle;
use App\Exception\ThrottleException;
use App\Register\ThrottleRegister;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\JoinPoint;
use Swoft\Redis\Redis;

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
     * @param JoinPoint $joinPoint
     * @throws ThrottleException
     */
    public function before(JoinPoint $joinPoint)
    {
        $className = $joinPoint->getClassName();
        $method = $joinPoint->getMethod();

        [$prefix,$key,$maxAccept,$ttl] = ThrottleRegister::get($className,$method);

        //第一次访问初始化计数1，有效时间$ttl
        $times = remember("{$prefix}{$key}",1,$ttl);
        if($times>$maxAccept) {
            //这种验证方式存在一点点bug啊，不过要求不严格可以用，在一个$ttl内最多可以访问2*$maxAccept-1次,细细品
            throw new ThrottleException('请求太频繁了');
        }

        Redis::incr("{$prefix}{$key}");
    }
}
