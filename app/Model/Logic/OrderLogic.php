<?php


namespace App\Model\Logic;

use App\Model\Entity\Order;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Exception\DbException;

/**
 * Class OrderLogic
 * @package App\Model\Logic
 * @Bean("OrderLogic")
 */
class OrderLogic
{
    /**
     * 获取用户订单列表
     *
     * @param array $param
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws DbException
     */
    public function list(array $param, int $page=1, int $pageSize=10): array
    {
        $where = [
            ['userId',context()->getRequest()->auth->id],
        ];

        $list = Order::whereProp($where)->forPage($page,$pageSize)->get();

        return $list->toArray();
    }
}
