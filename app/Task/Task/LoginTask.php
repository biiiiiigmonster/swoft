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
use Swoft\Log\Helper\Log;
use Swoft\Task\Annotation\Mapping\Task;
use Swoft\Task\Annotation\Mapping\TaskMapping;
use Swoole\Coroutine;

/**
 * Class LoginTask - define some tasks
 *
 * @Task()
 * @package App\Task\Task
 */
class LoginTask{

    /**
     * 保存用户登录信息
     *
     * @TaskMapping()
     * @param array $where
     * @param array $data
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function imprint(array $where,array $data): void
    {
        $row = User::where($where)->limit(1)->update($data);
        Log::warning('用户{'.$where['mobile'].'}登录信息保存失败');
        if(!$row) {
            Log::warning('用户{'.$where['mobile'].'}登录信息保存失败');
        }
    }
}
