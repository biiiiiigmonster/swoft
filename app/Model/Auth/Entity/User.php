<?php declare(strict_types=1);


namespace App\Model\Auth\Entity;

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
     * ????????
     *
     * @Column()
     *
     * @var string
     */
    private $mobile;

    /**
     * ????
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * ????
     *
     * @Column(name="login_status", prop="loginStatus")
     *
     * @var int
     */
    private $loginStatus;

    /**
     * ???????
     *
     * @Column(name="login_code", prop="loginCode")
     *
     * @var string
     */
    private $loginCode;

    /**
     * ????IP
     *
     * @Column(name="last_login_ip", prop="lastLoginIp")
     *
     * @var string
     */
    private $lastLoginIp;

    /**
     * ??????
     *
     * @Column(name="last_login_time", prop="lastLoginTime")
     *
     * @var string|null
     */
    private $lastLoginTime;

    /**
     * ????????????
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * ????
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var string
     */
    private $createTime;

    /**
     * ????
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var string
     */
    private $updateTime;

    /**
     * ?????
     *
     * @Column(name="delete_time", prop="deleteTime")
     *
     * @var string|null
     */
    private $deleteTime;


    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
