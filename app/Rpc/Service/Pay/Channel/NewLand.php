<?php declare(strict_types=1);


namespace App\Rpc\Service\Pay\Channel;

use App\Rpc\Service\Pay\Contract\ChannelInterface;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class NewLand
 * @Bean()
 * @package App\Rpc\Service\Pay\Channel
 */
class NewLand implements ChannelInterface
{
    /**
     * @inheritDoc
     */
    public function entry(array $data): array
    {
        return ['newland进件'];
    }

    /**
     * @inheritDoc
     */
    public function scan(array $data): array
    {
        return ['newland被扫'];
    }

    /**
     * @inheritDoc
     */
    public function dynamic(array $data): array
    {
        return ['newland主扫'];
    }

    /**
     * @inheritDoc
     */
    public function js(array $data): array
    {
        return ['newland小程序'];
    }

    /**
     * @inheritDoc
     */
    public function refund(array $data): bool
    {
        return true;
    }
}
