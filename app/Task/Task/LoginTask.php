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

use Swoft\App;
// use Swoft\Bean\Annotation\Inject;
// use Swoft\HttpClient\Client;
// use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Task\Bean\Annotation\Scheduled;
use Swoft\Task\Bean\Annotation\Task;

/**
 * Class LoginTask - define some tasks
 *
 * @Task("Login")
 * @package App\Task\Task
 */
class LoginTask{
    /**
     * A work task
     * do something
     *
     * @param string $p1
     * @param string $p2
     *
     * @return string
     */
    public function work(string $p1, string $p2)
    {
        App::profileStart('co');
        App::trace('trace');
        App::info('info');
        App::pushlog('key', 'stelin');
        App::profileEnd('co');

        return 'o, task completed';
    }

    /**
     * A cronTab task
     * 3-5 seconds per minute 每分钟第3-5秒执行
     *
     * @Scheduled(cron="3-5 * * * * *")
     */
    public function cronTask()
    {
        echo time() . "第3-5秒执行\n";

        return 'cron';
    }
}
