<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Rpc\Service;

use App\Model\Entity\User;
use App\Rpc\Lib\UserInterface;
use Exception;
use Firebase\JWT\JWT;
use Swoft\Co;
use Swoft\Db\Exception\DbException;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class UserServiceV2
 *
 * @since 2.0
 *
 * @Service(version="1.2")
 */
class UserServiceV2 implements UserInterface
{
    /**
     * 颁发授权
     * @param array $data
     * @param string $iss
     * @param string $aud
     * @return string
     */
    public function authorize(array $data,string $iss,string $aud): string
    {
        $time = time();
        $token = [
            'iat' => $time,//签发时间
            'nbf' => $time,//生效时间，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time + 3600*24*30,//过期时间
            "iss" => $iss,//签发者  ex: swoft.duzhaoteng.com
            'aud' => $aud,//接收者  ex: *.duzhaoteng.com
            'data' => $data,
//            'data' => [//自定义信息，不要定义敏感信息
//                'id' => $data['id'],//例如用户主键id
////                'mobile' => $data['mobile'],//用户手机号
//                //等等...
//            ],
        ];

        return JWT::encode($token, config('secret.jwt', 'CT5'),'HS256');
    }

    /**
     * @param int $id
     * @return array
     * @throws DbException
     */
    public function getInfo(int $id): array
    {
        $user = User::find($id);

        return $user->toArray();
    }

    /**
     * @param int   $id
     * @param mixed $type
     * @param int   $count
     *
     * @return array
     */
    public function getList(int $id, $type, int $count = 10): array
    {
        return [
            'name' => ['list','haha'],
            'v'    => '1.2'
        ];
    }

    /**
     * @return void
     */
    public function returnNull(): void
    {
        return;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getBigContent(): string
    {
        $content = Co::readFile(__DIR__ . '/big.data');
        return $content;
    }

    /**
     * Exception
     * @throws Exception
     */
    public function exception(): void
    {
        throw new Exception('exception version2');
    }

    /**
     * @param string $content
     *
     * @return int
     */
    public function sendBigContent(string $content): int
    {
        return strlen($content);
    }
}
