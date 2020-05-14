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
use Swoft\Stdlib\Helper\StringHelper;
use ReflectionException;
use RuntimeException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\Exception\DbException;

/**
 * Class UserLogic
 * @package App\Model\Logic
 * @Bean()
 */
class UserLogic
{
    /**
     * 用户登录
     *
     * @param array $param
     * @return array
     * @throws BizException
     * @throws DbException
     * @throws \Exception
     */
    public function login(array $param): array
    {
        $where = [
            ['mobile',$param['mobile']],
            ['password',md5($param['password'])]
        ];
        $user = User::where($where)->first();
        if(!$user)
            throw new BizException('',LOGIN_FAILED);

        $user->setLoginStatus(1);
        $user->setLoginCode(StringHelper::randomString('distinct',6));
        $user->save();

        return $user->toArray();
    }

    /**
     * 用户注册
     *
     * @param array $param
     * @return array
     * @throws DbException
     * @throws \Exception
     */
    public function register(array $param): array
    {
        $param['password'] = md5($param['password']);
        $user = User::new($param);
        $user->setLoginStatus(1);
        $user->setLoginCode(StringHelper::randomString('distinct',6));
        if(!$user->save()) {
            throw new RuntimeException('用户注册异常');
        }

        return $user->toArray();
    }
}
