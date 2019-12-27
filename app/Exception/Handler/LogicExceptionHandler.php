<?php


namespace App\Exception\Handler;


use App\Exception\LogicException;
use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Exception\Handler\AbstractHttpErrorHandler;
use Throwable;

/**
 * Class LogicExceptionHandler
 *
 * @since 2.0
 *
 * @ExceptionHandler(LogicException::class)
 */
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
