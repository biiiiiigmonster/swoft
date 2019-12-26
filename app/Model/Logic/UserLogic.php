<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Model\Logic;

use App\Exception\LogicException;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class UserLogic
 * @package App\Model\Logic
 * @Bean()
 */
class UserLogic
{
    /**
     * @param array $param
     * @return array
     * @throws LogicException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function login(array $param)
    {
        $user = User::where('mobile',$param['mobile'])->firstOrFail();
        if(md5($param['password'])!=$user->getPassword())
            throw new LogicException('账号或密码错误',100);

        return $user->toArray();
    }
}
