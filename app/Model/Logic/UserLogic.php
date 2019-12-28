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

use App\Exception\BizException;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;
use think\helper\Str;

/**
 * Class UserLogic
 * @package App\Model\Logic
 * @Bean("UserLogic")
 */
class UserLogic
{
    /**
     * @param array $param
     * @return array
     * @throws BizException
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function login(array $param): array
    {
        $user = User::where('mobile',$param['mobile'])->firstOrFail();
        if(md5($param['password'])!=$user->getPassword())
            throw new BizException('',LOGIN_FAILED);

        $user->setLoginStatus(1);
        $user->setLoginCode(Str::random());
        $user->save();

        return $user->toArray();
    }
}
