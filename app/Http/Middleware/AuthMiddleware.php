<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Middleware;

use App\Exception\ApiException;
use App\Exception\BizException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Exception;
use Swoft\Log\Helper\CLog;
use Swoft\Log\Helper\Log;
use function context;

/**
 * Class AuthMiddleware - Custom middleware
 * @Bean()
 * @package App\Http\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface|Request $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws ApiException
     * @throws BizException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // before request handle

        // 判断token
        $auth = $request->getHeaderLine("authorization");

        try {
            [$type,$token] = explode(' ',$auth);
//            JWT::$leeway = 60;//这个属性表示可以当前请求token的有效时间再延长60s
            $decoded = JWT::decode($token, config('secret.jwt', 'CT5'), ['HS256']);

            $request->auth = (object)$decoded->data;
        } catch (SignatureInvalidException $e){
            throw new ApiException('[ 验签失败 ] 签名无效',401);
        } catch (BeforeValidException $e){
            throw new ApiException('[ 验签失败 ] 解析失败',401);
        } catch (ExpiredException $e){
            throw new BizException('',AUTH_EXPIRED);
        } catch (Exception $e) {
            throw new ApiException('[ 验签失败 ] 解析失败',401);
        }
        //签发者验证
        if (!$this->issHostVerify($request,$decoded->iss)) {
            throw new ApiException('[ 验签失败 ] 来源不可靠',401);
        }
        //接收者验证
        if (!$this->audHostVerify($request,$decoded->aud)) {
            throw new ApiException('[ 验签失败 ] 签名无法验收',401);
        }
        $response = $handler->handle($request);
        return $response;

        // after request handle
    }

    /**
     * 签发者域名验证
     * @param Request $request
     * @param string $host
     * @return bool
     */
    private function issHostVerify(Request $request,string $host): bool
    {
        $allow = [
            //默认有效签发者域名为auth+当前站点的根域名
            $request->getUri()->getHost(),
            'auth.'.root_domain($request),
        ];
        //必须是指定签发者且协议头一致
        return in_array($host,$allow);
    }

    /**
     * 接收者域名验证
     * @param Request $request
     * @param string $host
     * @return bool
     */
    private function audHostVerify(Request $request,string $host):bool
    {
        $arr1 = array_reverse(array_filter(explode('.',$host)),false);
        $arr2 = array_reverse(array_filter(explode('.',sub_domain($request).'.'.root_domain($request))),false);
        //将接收者的域名与当前站点的域名进行比较（$arr1,$arr2此处的处理还需理解）
        $diff = array_diff_assoc($arr1,$arr2);
        foreach ($diff as $val) {
            if($val == '*') continue;
            return false;
        }

        return true;
    }
}
