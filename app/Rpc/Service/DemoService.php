<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Rpc\Service;

use App\Rpc\Lib\UserInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class DemoService - This is an controller for handle rpc request
 *
 * @Service()
 */
class DemoService
{
    /**
     * @return array
     */
    public function getList(): array
    {
        return ['item0', 'item1'];
    }
}
