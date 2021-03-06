<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
use App\Common\DbSelector;
use App\Process\MonitorProcess;
use Swoft\Crontab\Process\CrontabProcess;
use App\Http\Middleware\FavIconMiddleware;
use App\Http\Middleware\LauncherMiddleware;
use Swoft\Db\Pool;
use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\SyncTaskListener;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Http\Server\Swoole\RequestListener;
use Swoft\WebSocket\Server\WebSocketServer;
use Swoft\Server\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Redis\RedisDb;
use Swoft\Log\Handler\FileHandler;
use Swoft\Limiter\RateLimter;
use BiiiiiigMonster\Cache\Cache;

return [
    'lineFormatter'      => [
        'format'     => '%datetime% [%level_name%] [%channel%] [%event%] [tid:%tid%] [cid:%cid%] [traceid:%traceid%] [spanid:%spanid%] [parentid:%parentid%] %messages%',
        'dateFormat' => 'Y-m-d H:i:s',
    ],
    'noticeHandler'      => [
        'class'     => FileHandler::class,
        'logFile'   => '@runtime/logs/notice-%d{Y-m-d}.log',
        'formatter' => bean('lineFormatter'),
        'levels'    => 'notice,info,debug,trace',
    ],
    'applicationHandler' => [
        'class'     => FileHandler::class,
        'logFile'   => '@runtime/logs/error-%d{Y-m-d}.log',
        'formatter' => bean('lineFormatter'),
        'levels'    => 'error,warning',
    ],
    'logger'            => [
        'flushRequest' => false,
        'enable'       => true,
        'json'         => true,
        'handlers'     => [
            'application' => bean('applicationHandler'),
//            'notice'      => bean('noticeHandler'),
        ],
    ],
    'wsServer'          => [
        'class'   => WebSocketServer::class,
        'port'    => 18308,
        'on'      => [
            // Enable http handle
            SwooleEvent::REQUEST => bean(RequestListener::class),
            // 启用任务必须添加 task, finish 事件处理
            SwooleEvent::TASK => bean(TaskListener::class),
            SwooleEvent::FINISH => bean(FinishListener::class),
        ],
        'process'  => [
//            'monitor' => bean(MonitorProcess::class)
//            'crontab' => bean(CrontabProcess::class)
        ],
        'debug'   => env('SWOFT_DEBUG', 0),
        /* @see WebSocketServer::$setting */
        'setting' => [
            'log_file' => alias('@runtime/swoole.log'),
            // 任务需要配置 task worker
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true,
            'worker_num'            => 6,
        ],
    ],
    'httpServer'        => [
        'class'    => HttpServer::class,
        'port'     => 18306,
//        'listener' => [
//            'rpc' => bean('rpcServer'),
//            'ws'  => bean('wsServer')
//        ],
        'process'  => [
//            'monitor' => bean(MonitorProcess::class)
//            'crontab' => bean(CrontabProcess::class)
        ],
        'on'       => [
//            SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting' => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true,
            'worker_num'            => 6,
        ]
    ],
    'httpRouter'  => [
        'handleMethodNotAllowed' => true
    ],
    'httpDispatcher'    => [
        // Add global http middleware
        'middlewares'      => [
            FavIconMiddleware::class,
            LauncherMiddleware::class,
        ],
        'afterMiddlewares' => [
            \Swoft\Http\Server\Middleware\ValidatorMiddleware::class
        ]
    ],
    'serviceDispatcher'    => [
        'afterMiddlewares' => [
            \Swoft\Rpc\Server\Middleware\ValidatorMiddleware::class
        ]
    ],
    'db'                => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=tp6;host=123.207.255.238;port=13306',
        'username' => 'tp6',
        'password' => 'rhf$[TF}42ad',
    ],
    'db.pool' => [
        'class'    => Pool::class,
        'database' => bean('db'),
    ],
    'db2'               => [
        'class'      => Database::class,
        'dsn'        => 'mysql:dbname=idx;host=123.207.255.238;port=13306',
        'username'   => 'tp6',
        'password'   => 'rhf$[TF}42ad',
//        'dbSelector' => bean(DbSelector::class)
    ],
    'db2.pool' => [
        'class'    => Pool::class,
        'database' => bean('db2'),
    ],
    'db3'               => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=partitions;host=123.207.255.238;port=13306',
        'username' => 'tp6',
        'password' => 'rhf$[TF}42ad',
    ],
    'db3.pool'          => [
        'class'    => Pool::class,
        'database' => bean('db3')
    ],
    'db4'               => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=unionall;host=123.207.255.238;port=13306',
        'username' => 'tp6',
        'password' => 'rhf$[TF}42ad',
    ],
    'db4.pool'          => [
        'class'    => Pool::class,
        'database' => bean('db4')
    ],
    'migrationManager'  => [
        'migrationPath' => '@database/Migration',
    ],
    'redis'             => [
        'class'    => RedisDb::class,
        'host'     => '123.207.255.238',
        'port'     => 6379,
        'password' => 'BBOqWsva',
        'database' => 0,
        'option'   => [
            'prefix' => 'swoft:',
            'serializer' => Redis::SERIALIZER_JSON,
        ]
    ],
    'user'              => [
        'class'   => ServiceClient::class,
        'host'    => '123.207.255.238',//172.16.0.2
        'port'    => 18307,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'user.pool'         => [
        'class'  => ServicePool::class,
        'client' => bean('user'),
    ],
    'gateway'              => [
        'class'   => ServiceClient::class,
        'host'    => '123.207.255.238',//192.168.99.100
        'port'    => 18307,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'gateway.pool'         => [
        'class'  => ServicePool::class,
        'client' => bean('gateway'),
    ],
    'sms'              => [
        'class'   => ServiceClient::class,
        'host'    => '123.207.255.238',//172.16.0.2
        'port'    => 18307,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'sms.pool'         => [
        'class'  => ServicePool::class,
        'client' => bean('sms'),
    ],
    'email'              => [
        'class'   => ServiceClient::class,
        'host'    => '123.207.255.238',//172.16.0.2
        'port'    => 18307,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'email.pool'         => [
        'class'  => ServicePool::class,
        'client' => bean('email'),
    ],
    'rpcServer'         => [
        'class' => ServiceServer::class,
        'port' => 18307,
    ],
    'tcpServer'         => [
        'port'  => 18309,
        'debug' => 1,
    ],
    /** @see \Swoft\Tcp\Protocol */
    'tcpServerProtocol' => [
        // 'type'            => \Swoft\Tcp\Packer\JsonPacker::TYPE,
        'type' => \Swoft\Tcp\Packer\SimpleTokenPacker::TYPE,
        // 'openLengthCheck' => true,
    ],
    'cliRouter'         => [
        // 'disabledGroups' => ['demo', 'test'],
    ],
    'i18n'              => [
        // 设置到文本资源目录
        'resourcePath' => '@resource/language/', // 结尾斜线必须

        // 设置默认文本文件夹名称
        // 未填写则默认 en 文件夹
        'defaultLanguage'   => 'zh_CN',

        // 设置默认文本文件名称
        // 未填写则默认 default.php
        'defaultCategory'   => 'errmsg',
    ],
    'config'   => [
        'path' => alias('@config'),
    ],
    Cache::MANAGER => [
        'el' => bean('expressionLanguage'),
    ],
];
