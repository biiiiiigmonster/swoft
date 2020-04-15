<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Task\Task;

use App\Model\Entity\User;
use Carbon\Carbon;
use Swoft\Log\Helper\CLog;
use Swoft\Log\Helper\Log;
use Swoft\Task\Annotation\Mapping\Task;
use Swoft\Task\Annotation\Mapping\TaskMapping;
use Swoole\Coroutine;

/**
 * Class LoginTask - define some tasks
 *
 * @Task("LoginTask")
 * @package App\Task\Task
 */
class LoginTask{

    /**
     * 保存用户登录信息
     *
     * @TaskMapping()
     * @param User $user
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function imprint(User $user): void
    {
        CLog::info('异步：'.ip());
//        $user->setLastLoginIp(ip());
//        $user->setLastLoginTime(Carbon::now()->toDateTimeString());
//        $res = $user->save();
//
//        if(!$res) {
//            Log::warning("用户\{{$user->getMobile()}}\}登录信息保存失败");
//        }
    }
}
