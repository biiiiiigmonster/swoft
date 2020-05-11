<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Controller;

use App\Model\Entity\User;
use Exception;
use Swoft\Log\Helper\CLog;
use Swoole\Timer\Iterator;
use function random_int;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Log\Helper\Log;
use Swoft\Redis\Redis;
use Swoft\Stdlib\Helper\JsonHelper;
use Swoft\Timer;

/**
 * Class TimerController
 *
 * @since 2.0
 *
 * @Controller(prefix="timer")
 */
class TimerController
{
    /**
     * @RequestMapping()
     * @return array|string[]
     */
    public function test(): array
    {
        $short = fn(int $timerId,$q,$a) => CLog::info("{$timerId}我这是定时器{$q}:{$a}");
        return [
            Timer::tick(1*1000,$short,'说啥好呢','那就闭嘴'),
            Timer::tick(2*1000,$short,'喂，在干嘛','在看书'),
            Timer::tick(3*1000,$short,'瞅你咋滴','信不信我削你'),
        ];
    }

    /**
     * @RequestMapping()
     * @return Iterator
     */
    public function list(): Iterator
    {
        return Timer::list();
    }

    /**
     * @RequestMapping("{timerId}")
     * @param int $timerId
     * @return bool
     */
    public function clear(int $timerId): bool
    {
        return Timer::clear($timerId);
    }

    /**
     * @RequestMapping()
     * @return bool
     */
    public function clearAll(): bool
    {
        return Timer::clearAll();
    }

    /**
     * @RequestMapping()
     *
     * @return array
     * @throws Exception
     */
    public function after(): array
    {
        Timer::after(3 * 1000, function (int $timerId) {
            $user = new User();
            $user->setAge(random_int(1, 100));
            $user->setUserDesc('desc');

            $user->save();
            $id = $user->getId();

            Redis::set("$id", $user->toArray());
            Log::info('用户ID=' . $id . ' timerId=' . $timerId);
            sgo(function () use ($id) {
                $user = User::find($id)->toArray();
                Log::info(JsonHelper::encode($user));
                Redis::del("$id");
            });
        });

        return ['after'];
    }

    /**
     * @RequestMapping()
     *
     * @return array
     * @throws Exception
     */
    public function tick(): array
    {
        Timer::tick(3 * 1000, function (int $timerId) {
            $user = new User();
            $user->setAge(random_int(1, 100));
            $user->setUserDesc('desc');

            $user->save();
            $id = $user->getId();

            Redis::set("$id", $user->toArray());
            Log::info('用户ID=' . $id . ' timerId=' . $timerId);
            sgo(function () use ($id) {
                $user = User::find($id)->toArray();
                Log::info(JsonHelper::encode($user));
                Redis::del("$id");
            });
        });

        return ['tick'];
    }
}
