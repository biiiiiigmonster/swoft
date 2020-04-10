<?php
use Swoft\Redis\Redis;

/**
 * 不存在则写入缓存数据后返回
 * @param string $key
 * @param mixed $value 缓存数据，支持闭包传参
 * @param int|DateInterval $ttl 过期时间
 * @return mixed
 */
function remember(string $key,$value,$ttl = null)
{
    $cache = Redis::get($key);
    if($cache !== false) {
        return $cache;
    }

    if($value instanceof Closure) {
        $value = $value();
    }
    Redis::set($key,$value,$ttl);//$ttl参数的格式化还没有做，只能是null或者int（或者DateInterval），所以传参的最好乖点

    return $value;
}
