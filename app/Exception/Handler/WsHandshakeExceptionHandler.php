<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Http\Message\Response;
use Swoft\Log\Helper\Log;
use Swoft\WebSocket\Server\Exception\Handler\AbstractHandshakeErrorHandler;
use Throwable;
use function get_class;
use function sprintf;
use const APP_DEBUG;

/**
 * Class HttpExceptionHandler
 *
 * @ExceptionHandler(\Throwable::class)
 */
class WsHandshakeExceptionHandler extends AbstractHandshakeErrorHandler
{
    /**
     * @param Throwable $e
     * @param Response  $response
     *
     * @return Response
     */
    public function handle(Throwable $e, Response $response): Response
    {
        // Log
        Log::error(sprintf(
            '%s At %s line %d',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        ));
        // Debug is false
        if (!APP_DEBUG) {
            return $response->withStatus(500)->withContent(sprintf(
                '%s',
                $e->getMessage()
            ));
        }

        $data = [
            'code'  => $e->getCode() ?? ERRORS,
            'error' => sprintf('(%s) %s', get_class($e), $e->getMessage()),
            'file'  => sprintf('At %s line %d', $e->getFile(), $e->getLine()),
            'trace' => $e->getTraceAsString(),
        ];

        // Debug is true
        return $response->withData($data);
    }
}
