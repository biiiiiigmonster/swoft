<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Api;

use App\Http\Middleware\AuthMiddleware;
use App\Model\Logic\OrderLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Db\Exception\DbException;
use Swoft\Log\Helper\Log;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Validator\Annotation\Mapping\ValidateType;

/**
 * Class OrderController
 *
 * @Controller(prefix="/order")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class)
 * })
 * @package App\Http\Api
 */
class OrderController{
    /**
     * @Inject("OrderLogic")
     *
     * @var OrderLogic
     */
    private $logic;

    /**
     * 获取订单列表
     * @RequestMapping(route="/order",method=RequestMethod::GET)
     * @Validate(validator="OrderValidator",type=ValidateType::GET,fields={})
     *
     * @param Request $request
     * @return array
     * @throws DbException
     */
    public function list(Request $request): array
    {
        Log::error('我出错啦！');
        $param = $request->get();
        /** @var Int */
        $page = $request->get('page',1);
        /** @var Int */
        $pageSize = $request->get('pageSize',10);

        $total = $this->logic->total($param);
        $list = $this->logic->list($param,(int)$page,(int)$pageSize);

        return [
            'total' => $total,
            'list' => $list,
        ];
    }
}
