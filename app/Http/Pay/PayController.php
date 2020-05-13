<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Pay;

use App\Rpc\Lib\GatewayInterface;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class PayController
 *
 * @Controller(prefix="/pay")
 * @package App\Http\Pay
 */
class PayController{

    /**
     * @Reference(pool="gateway.pool")
     *
     * @var GatewayInterface
     */
    private GatewayInterface $gatewayService;

    /**
     * 支付下单
     * @RequestMapping(route="{payMethod}", method=RequestMethod::POST)
     *
     * @param Request $request
     * @param string $payMethod
     * @return array
     */
    public function pay(Request $request,string $payMethod): array
    {
        $data = $request->post();

        $res = $this->gatewayService->pay($payMethod, $data);

        return $res;
    }

    /**
     * 支付回调
     * @RequestMapping(route="/notify", method=RequestMethod::POST)
     *
     * @param Request $request
     * @return string
     */
    public function notify(Request $request): string
    {
        return 'success';
    }
}
