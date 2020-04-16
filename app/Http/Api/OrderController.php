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

use App\Annotation\Mapping\Throttle;
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
     * @Inject()
     *
     * @var OrderLogic
     */
    private $logic;

    /**
     * 获取订单列表
     * @RequestMapping(route="{page}/{pageSize}",method=RequestMethod::GET)
     * @Validate(validator="OrderValidator",type=ValidateType::GET)
     *
     * @param Request $request
     * @param Int $page
     * @param Int $pageSize
     * @return array
     * @throws DbException
     */
    public function list(Request $request,int $page,int $pageSize=10): array
    {
        $param = $request->get();

        $total = $this->logic->total($param);
        $list = $this->logic->list($param,$page,$pageSize);

        return [
            'total' => $total,
            'list' => $list->toArray(),
        ];
    }

    /**
     * 获取订单详情
     *
     * @RequestMapping(route="{id}",method=RequestMethod::GET)
     * @Throttle()
     * @param int $id
     * @return array
     * @throws DbException
     */
    public function detail(int $id): array
    {
        $detail = $this->logic->detail($id);

        return $detail->toArray();
    }
}
