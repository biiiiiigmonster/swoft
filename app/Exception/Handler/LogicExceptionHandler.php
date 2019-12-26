<?php


namespace App\Exception\Handler;


use Swoft\Http\Message\Response;
use Swoft\Http\Server\Exception\Handler\AbstractHttpErrorHandler;
use Throwable;

class LogicExceptionHandler extends AbstractHttpErrorHandler
{
    /**
     * @param Throwable $except
     * @param Response $response
     *
     * @return Response
     */
    public function handle(Throwable $except, Response $response): Response
    {
        // TODO: Implement handle() method.
        $data = [
            'code' => $except->getCode(),
            'msg' => $except->getMessage(),
        ];

        return $response->withData($data);
    }
}
