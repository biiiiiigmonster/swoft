<?php


namespace App\Event;

/**
 * Class UserEvent
 * @package App\Event
 * @since 2.0
 */
class UserEvent
{
    /**
     * 注册
     */
    public const REGISTER = 'user.register';

    /**
     * 登录
     */
    public const LOGIN = 'user.login';

    /**
     * 退出
     */
    public const LOGOUT = 'user.logout';

    /**
     * 销户
     */
    public const CLOSE = 'user.close';
}
