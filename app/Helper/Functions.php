<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
use Swoft\Stdlib\Helper\ArrayHelper;
use Swoft\Http\Message\Request;

if (!function_exists('format')) {
    /**
     * 格式化返回数据
     * @param null      $data
     * @param int       $errcode
     * @param string    $errmsg
     * @return array
     */
    function format($data=null,$errcode=SUCCESS,$errmsg=''): array
    {
        if(is_null($data)) {
            $data = '';
        }

        return [
            'errcode'    => $errcode,
            'errmsg'     => $errmsg?:Swoft::t((string)$errcode),
            'data'       => $data,
        ];
    }
}

if (!function_exists('ws_format')) {
    /**
     * WebsocketServer push data format
     * @param $action
     * @param null|mixed $data
     * @return string
     */
    function ws_format($action,$data=null): string
    {
        $arr = ['action' => $action];
        if(!is_null($data)) {
            $arr['data'] = $data;
        }
        return json_encode($arr);
    }
}

if (!function_exists('root_domain')) {
    /**
     * 获取当前根域名
     * @param Request $request
     * @return string
     */
    function root_domain(Request $request): string
    {
        $item  = explode('.', $request->getUri()->getHost());
        $count = count($item);
        return $count > 1 ? $item[$count - 2] . '.' . $item[$count - 1] : $item[0];
    }
}

if (!function_exists('sub_domain')) {
    /**
     * 获取当前子域名
     * @param Request $request
     * @return string
     */
    function sub_domain(Request $request): string
    {
        // 获取当前主域名
        $rootDomain = root_domain($request);

        return rtrim(stristr($request->getUri()->getHost(), $rootDomain, true), '.');
    }
}

if (!function_exists('ip')) {
    /**
     * 获取客户端的真实IP
     * @param Request $request
     * @return string
     */
    function ip(Request $request): string
    {
        $serverParams = $request->getServerParams();
        $HeaderParams = $request->getHeaders();

        /** var String */
        return $HeaderParams['x-real-ip'][0]??$HeaderParams['x-forwarded-for'][0]??$serverParams['remote_addr']??'0.0.0.0';
    }
}
