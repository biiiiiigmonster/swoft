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
use Swoft\Log\Debug;
use Swoft\Rpc\Error;
use Swoft\Rpc\Server\Exception\Handler\RpcErrorHandler;
use Swoft\Rpc\Server\Response;
use Throwable;

/**
 * Class RpcExceptionHandler
 *
 * @since 2.0
 *
 * @ExceptionHandler(\Throwable::class)
 */
class RpcExceptionHandler extends RpcErrorHandler
{
    /**
     * @param Throwable $e
     * @param Response  $response
     *
     * @return Response
     */
    public function handle(Throwable $e, Response $response): Response
    {
        // APP_DEBUG is true
        if (APP_DEBUG) {
            $message = sprintf(' %s At %s line %d', $e->getMessage(), $e->getFile(), $e->getLine());
        } else {
            // just show error message
            $message = $e->getMessage();
        }

        $error   = Error::new($e->getCode(), $message, null);
        Debug::log('Rpc server error(%s)', $e->getMessage());

        $response->setError($error);

        // Debug is true
        return $response;
    }
}
