<?php


namespace App\Exception\Handler;



use BiiiiiigMonster\Throttle\Exception\ThrottleException;
use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Exception\Handler\AbstractHttpErrorHandler;
use Swoft\Log\Helper\Log;
use Throwable;

/**
 * Class ThrottleExceptionHandler
 * @package App\Exception\Handler
 *
 * @ExceptionHandler(ThrottleException::class)
 */
class ThrottleExceptionHandler extends AbstractHttpErrorHandler
{
    /**
     * @param Throwable $except
     * @param Response $response
     * @return Response
     */
    public function handle(Throwable $except, Response $response): Response
    {
        // Log
        Log::error(sprintf(' %s At %s line %d', $except->getMessage(), $except->getFile(), $except->getLine()));

        // Debug is false
        if (!APP_DEBUG) {
            return $response->withStatus(429)->withContent(
                sprintf(' %s', 'Too Many Requests')
            );
        }

        $data = format(null,FAILED,$except->getMessage());

        return $response->withData($data);
    }
}
