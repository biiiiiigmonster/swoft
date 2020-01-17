<?php


namespace App\Aspect;


use App\Model\Logic\OrderLogic;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointExecution;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Log\Helper\CLog;

/**
 * Class CacheAspect
 * @package App\Aspect
 *
 * @Aspect(order=1)
 *
 * @PointExecution(
 *     include={
 *      OrderLogic::detail,
 *     }
 * )
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
        return $ret;
    }
}
