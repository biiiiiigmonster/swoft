<?php


namespace App\Aspect;


use App\Annotation\Mapping\Throttle;
use App\Exception\ThrottleException;
use App\Register\ThrottleRegister;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\JoinPoint;
use Swoft\Log\Helper\CLog;
use Swoft\Redis\Redis;

/**
 * Class ThrottleAspect
 * @package App\Aspect
 * @Aspect()
 * @PointAnnotation(
 *     include={Throttle::class}
 * )
 */
class ThrottleAspect
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
        $argsMap = $joinPoint->getArgsMap();

        [$prefix,$key,$maxAccept,$ttl] = ThrottleRegister::get($className,$method);
        if(!$key = ThrottleRegister::evaluateKey($key,$className,$method,$argsMap)) {
            //如果没有从缓存注解中解析出有效key（因为ThrottleRegister注解key非必填），则采用默认规则来赋值key
            $key = "$className@$method";
        }
        //第一次访问初始化计数1，有效时间$ttl
        $times = remember("{$prefix}{$key}",1,$ttl);
        if($times>$maxAccept) {
            //这种验证方式存在一点点bug啊，不过要求不严格可以用，在一个$ttl内最多可以访问2*$maxAccept-1次,细细品
            throw new ThrottleException('请求太频繁了');
        }
        Redis::incr("{$prefix}{$key}");
    }
}
