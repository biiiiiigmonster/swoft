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
