<?php


namespace App\Model\Logic;

use App\Model\Entity\Order;
use BiiiiiigMonster\Cache\Annotation\Mapping\Cache;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Eloquent\Collection;
use Swoft\Db\Exception\DbException;
use Swoft\Log\Helper\CLog;

/**
 * Class OrderLogic
 * @package App\Model\Logic
 * @Bean()
 */
class OrderLogic
{
    /**
     * @param array $param
     * @return array
     */
    public function where(array $param): array
    {
        $where = [
            ['user_id',context()->getRequest()->auth->id],
        ];

        return $where;
    }

    /**
     * @return array
     */
    public function relation(): array
    {
        return [];
    }

    /**
     * @param array $param
     * @return int
     */
    public function total(array $param): int
    {
        $model = Order::whereProp($this->where($param))
            ->whereBetween('create_time',[$param['start'],$param['end']]);

        return $model->count();
    }

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
        $model = Order::whereProp($this->where($param))
            ->whereBetween('create_time',[$param['start'],$param['end']]);
        if($page) $model->forPage($page,$pageSize);
        $list = $model->get();

        return $list->toArray();
    }

    /**
     * 获取订单详情
     *
     * @Cache(key="'order:'~id",ttl=60)
     * @param int $id
     * @return array
     * @throws DbException
     */
    public function detail(int $id): array
    {
        $order = Order::find($id);

        return $order->toArray();
    }
}
