<?php declare(strict_types=1);


namespace App\Exception\Handler;


use App\Exception\BizException;
use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Exception\Handler\AbstractHttpErrorHandler;
use Throwable;

/**
 * Class BizExceptionHandler
 *
 * @since 2.0
 *
 * @ExceptionHandler(BizException::class)
 */
class BizExceptionHandler extends AbstractHttpErrorHandler
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
        $data = format(null,$except->getCode(),$except->getMessage());

        return $response->withData($data);
    }
}
