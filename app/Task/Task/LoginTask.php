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
 * @Task(name="LoginTask")
 * @package App\Task\Task
 */
class LoginTask{

    /**
     * 保存用户登录信息
     *
     * @TaskMapping(name="imprint")
     * @param int $id
     * @param array $data
     */
    public function imprint(int $id,array $data): void
    {
        Coroutine::sleep(5);
        $row = User::modifyById($id,$data);
        if(!$row) {
            Log::warning("用户\{$id\}登录信息保存失败");
        }
    }
}
