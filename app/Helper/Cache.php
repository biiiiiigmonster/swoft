<?php
use Swoft\Redis\Redis;

/**
 * @param string $key
 * @param Closure $callback
 * @param $ttl
 * @return mixed
 */
function remember(string $key,Closure $callback,$ttl = null)
{
    $value = Redis::get($key);
    if(!is_null($value)) {
        return $value;
    }

    //$ttl参数的格式化还没有做，只能是null或者int（或者DateInterval），所以传参的最好乖点
    Redis::set($key,$value = $callback(),$ttl);
    \Swoft\Log\Helper\CLog::debug(json_encode($value));
    return $value;
}
