<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\WebSocket;

use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Log\Helper\CLog;
use Swoft\Redis\Redis;
use Swoft\WebSocket\Server\Annotation\Mapping\WsModule;
use Swoft\WebSocket\Server\Annotation\Mapping\OnOpen;
use Swoft\WebSocket\Server\Annotation\Mapping\OnClose;
use Swoft\WebSocket\Server\Annotation\Mapping\OnHandshake;
use Swoft\WebSocket\Server\MessageParser\TokenTextParser;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Class AuthModule - This is an module for handle websocket
 *
 * @WsModule(
 *    "/auth"
 *  )
 */
class AuthModule{
    /**
     * 在这里你可以验证握手的请求信息
     * - 必须返回含有两个元素的array
     *  - 第一个元素的值来决定是否进行握手
     *  - 第二个元素是response对象
     * - 可以在response设置一些自定义header,body等信息
     *
     * @OnHandshake()
     * @param Request $request
     * @param Response $response
     * @return array
     */
    public function checkHandshake(Request $request, Response $response): array
    {
        // some validate logic ...
        CLog::info($request->getHeaderLine('authorization'));
        return [true, $response];
    }

    /**
     * @OnOpen()
     * @param Request $request
     * @param int $fd
     * @return mixed
     */
    public function onOpen(Request $request, int $fd)
    {
//        Redis::set($request->query('uuid'),$fd);
        server()->push($fd, 'hello, welcome! :)');
    }

    /**
     * @OnClose()
     * @param Server $server
     * @param int $fd
     * @return mixed
     */
    public function onClose(Server $server, int $fd)
    {
        // do something. eg. record log
    }
}
