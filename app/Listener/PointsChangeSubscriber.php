<?php


namespace App\Listener;


use App\Event\PointsEvent;
use App\Event\UserEvent;
use App\Model\Entity\User;
use Swoft\Co;
use Swoft\Event\Annotation\Mapping\Subscriber;
use Swoft\Event\EventInterface;
use Swoft\Event\EventSubscriberInterface;
use Swoft\Event\Listener\ListenerPriority;
use Swoft\Log\Helper\CLog;

/**
 * Class PointsChangeSubscriber
 * @package App\Listener
 *
 * @Subscriber()
 */
class PointsChangeSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            UserEvent::LOGIN => 'userLogin',
            PointsEvent::ADD => 'pointsAdd',
            'points.change.*' => ['pointsChangeNotify', ListenerPriority::LOW],//设置事件触发优先级
        ];
    }

    /**
     * 用户登录添加积分
     * @param EventInterface $event
     */
    public function userLogin(EventInterface $event): void
    {
        /** @var User $user */
        $user = $event->getTarget();
        $points = 10;

        \Swoft::trigger(PointsEvent::ADD,$user,$points);
    }

    /**
     * 积分变更，下发通知
     * @param EventInterface $event
     */
    public function pointsChangeNotify(EventInterface $event): void
    {
        /** @var User $user */
        $user = $event->getTarget();

        CLog::info('用户：'.$user->getMobile().'积分发生变更，请前往邮件查看');
    }

    /**
     * 积分增加，友情提示
     * @param EventInterface $event
     */
    public function pointsAdd(EventInterface $event): void
    {
        /** @var User $user */
        $user = $event->getTarget();

        $points = $event->getParam(0);

        CLog::info('尊敬的用户'.$user->getMobile().'，恭喜你获得'.$points.'积分，再接再厉哟~');
    }
}
