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
     * 减少
     */
    public const SUBTRACT = 'points.change.subtract';

    /**
     * 清零
     */
    public const CLEAR = 'points.clear';
}
