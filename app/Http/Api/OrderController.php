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
     * @RequestMapping(route="list",method=RequestMethod::GET)
     *
     * @param Request $request
     * @return array
     * @throws DbException
     */
    public function getList(Request $request): array
    {
        $param = $request->get();

        $list = $this->logic->getList($param);

        return ['list' => $list];
    }
}
