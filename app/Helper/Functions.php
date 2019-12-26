<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

function user_func(): string
{
    return 'hello';
}

/**
 * 获取当前根域名
 * @access public
 * @return string
 */
function rootDomain(): string
{
    $item  = explode('.', context()->getRequest()->getHost());
    $count = count($item);
    return $count > 1 ? $item[$count - 2] . '.' . $item[$count - 1] : $item[0];
}

/**
 * 获取当前子域名
 * @access public
 * @return string
 */
function subDomain(): string
{
    // 获取当前主域名
    $rootDomain = rootDomain();

    return rtrim(stristr(context()->getRequest()->getHost(), $rootDomain, true), '.');
}

/**
 * 获取客户端的真实IP
 * @return string
 */
function ip(): string
{
    $serverParams = context()->getRequest()->getServerParams();
    $HeaderParams = context()->getRequest()->getHeaders();

    /** var String */
    $ip = $HeaderParams['x-real-ip'][0]??$HeaderParams['x-forwarded-for'][0]??$serverParams['remote_addr']??'0.0.0.0';

    return $ip;
}
