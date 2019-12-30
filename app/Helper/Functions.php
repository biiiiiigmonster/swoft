<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
define('SUCCESS', 0);
define('NULL_PARAM', 10010);
define('ERRORS', 10500);
define('ERRORS_METHOD', 10012);
define('ERRORS_PARAM', 10013);
define('FAILED', 10014);
define('FAILED_AUTHENTICATE', 10015);
define('NULL_DATA', 10016);
define('HAS_VOSTED', 10017);
define('CODE_ERROR', 10019);
define('DATA_EXIST', 10020);
define('EMAIL_NOT_EXIST', 10021);
define('ERRORS_PASS', 10022);
define('LOGIN_OUT', 10023);
define('NOT_ACTIVAT', 10024);
define('LOGIN_FAILED', 10025);
define('OLDPASS_ERROR', 10026);
define('FINDPASS_FAILED', 10027);
define('USERNAME_LENGTH', 10028);
define('EMAIL_FORMAT_ERROR', 10029);
define('CANT_MODIFY_DEPART', 10030);
define('NO_CHINESE', 10031);
define('TEXT_TOO_LENGTH', 10032);
define('NULL_WHERE', 10033);
define('TABLE_NOT_FOUND', 10034);
define('TOKEN_MISS', 10035);
define('NO_ACCESS', 10036);
define('NOT_CHECK', 10037);
define('MISS_PARAM', 10038);
define('CAPTCHA_ERROR', 10039);
define('NULL_FILE', 10040);
define('INSUFFICIENT_BALANCE', 10041);
define('FILE_PARSE_FAILED', 10042);
define('SECRET_ERROR', 10043);
define('NOT_REGISTER', 10044);
define('ROUTE_MISS', 10045);

/**
 * 格式化返回数据
 * @param null $data
 * @param int $code
 * @param string $msg
 * @return array
 */
function format($data=null,$code=SUCCESS,$msg=''): array
{
    $return['code'] = $code;
    $return['data'] = ['msg' => $msg?:Swoft::t((string)$code)];

    //判断能否当做数组一样访问
    if(\think\helper\Arr::accessible($data)) {
        $return['data'] = array_merge($return['data'],(array)$data);
    } else {
        $return = $data;
    }

    return $return;
}

/**
 * 获取当前根域名
 * @access public
 * @return string
 */
function rootDomain(): string
{
    $item  = explode('.', context()->getRequest()->getUri()->getHost());
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

    return rtrim(stristr(context()->getRequest()->getUri()->getHost(), $rootDomain, true), '.');
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
