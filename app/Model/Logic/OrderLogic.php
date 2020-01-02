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
    public function list(array $param, int $page=0, int $pageSize=10): array
    {
        $model = Order::whereProp($this->where($param))->whereBetween('createTime',[$param['start'],$param['end']]);
        if($page) $model->forPage($page,$pageSize);
        $list = $model->get();

        return $list->toArray();
    }

    /**
     * @param array $param
     * @return array
     */
    public function where(array $param): array
    {
        $where = [
            ['userId',context()->getRequest()->auth->id],
        ];

        return $where;
    }
}
