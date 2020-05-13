<?php declare(strict_types=1);


namespace App\Rpc\Lib;

/**
 * 暂时没啥用哈
 * Interface CaptchaInterface
 * @package App\Rpc\Lib
 */
interface CaptchaInterface
{
    public function create(): array;
    public function verify(): bool;
}
