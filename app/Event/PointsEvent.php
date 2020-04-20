<?php


namespace App\Event;

/**
 * Class PointsEvent
 * @package App\Event
 * @since 2.0
 */
class PointsEvent
{
    /**
     * 增加
     */
    public const ADD = 'points.change.add';

    /**
     * 消费
     */
    public const COST = 'points.change.cost';

    /**
     * 清零
     */
    public const CLEAR = 'points.clear';
}
