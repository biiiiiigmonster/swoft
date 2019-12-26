<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * ???
 * Class User
 *
 * @since 2.0
 *
 * @Entity(table="user")
 */
class User extends Model
{
    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 手机号，登陆使用
     *
     * @Column()
     *
     * @var string
     */
    private $mobile;

    /**
     * 用户密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 登陆状态
     *
     * @Column(name="login_status", hidden=true, prop="loginStatus")
     *
     * @var int
     */
    private $loginStatus;

    /**
     * 排他性登陆标识
     *
     * @Column(name="login_code", prop="loginCode")
     *
     * @var string
     */
    private $loginCode;

    /**
     * 最后登录IP
     *
     * @Column(name="last_login_ip", prop="lastLoginIp")
     *
     * @var string
     */
    private $lastLoginIp;

    /**
     * 最后登录时间
     *
     * @Column(name="last_login_time", prop="lastLoginTime")
     *
     * @var string|null
     */
    private $lastLoginTime;

    /**
     * 账号状态，状态信息见配置
     *
     * @Column(hidden=true)
     *
     * @var int
     */
    private $status;

    /**
     * 创建时间
     *
     * @Column(name="create_time", hidden=true, prop="createTime")
     *
     * @var string
     */
    private $createTime;

    /**
     * 更新时间
     *
     * @Column(name="update_time", hidden=true, prop="updateTime")
     *
     * @var string
     */
    private $updateTime;

    /**
     * 软删除时间
     *
     * @Column(name="delete_time", hidden=true, prop="deleteTime")
     *
     * @var string|null
     */
    private $deleteTime;

    /**
     * @param string $mobile
     *
     * @return void
     */
    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param int $loginStatus
     *
     * @return void
     */
    public function setLoginStatus(int $loginStatus): void
    {
        $this->loginStatus = $loginStatus;
    }

    /**
     * @param string $loginCode
     *
     * @return void
     */
    public function setLoginCode(string $loginCode): void
    {
        $this->loginCode = $loginCode;
    }

    /**
     * @param string $lastLoginIp
     *
     * @return void
     */
    public function setLastLoginIp(string $lastLoginIp): void
    {
        $this->lastLoginIp = $lastLoginIp;
    }

    /**
     * @param string|null $lastLoginTime
     *
     * @return void
     */
    public function setLastLoginTime(?string $lastLoginTime): void
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string $createTime
     *
     * @return void
     */
    public function setCreateTime(string $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @param string $updateTime
     *
     * @return void
     */
    public function setUpdateTime(string $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @param string|null $deleteTime
     *
     * @return void
     */
    public function setDeleteTime(?string $deleteTime): void
    {
        $this->deleteTime = $deleteTime;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getLoginStatus(): ?int
    {
        return $this->loginStatus;
    }

    /**
     * @return string
     */
    public function getLoginCode(): ?string
    {
        return $this->loginCode;
    }

    /**
     * @return string
     */
    public function getLastLoginIp(): ?string
    {
        return $this->lastLoginIp;
    }

    /**
     * @return string|null
     */
    public function getLastLoginTime(): ?string
    {
        return $this->lastLoginTime;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

    /**
     * @return string
     */
    public function getUpdateTime(): ?string
    {
        return $this->updateTime;
    }

    /**
     * @return string|null
     */
    public function getDeleteTime(): ?string
    {
        return $this->deleteTime;
    }

}
