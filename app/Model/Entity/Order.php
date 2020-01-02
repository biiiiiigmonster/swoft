<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * ???
 * Class Order
 *
 * @since 2.0
 *
 * @Entity(table="order", pool="db2.pool")
 */
class Order extends Model
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
     * ????id
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * ??id
     *
     * @Column(name="merchant_id", prop="merchantId")
     *
     * @var int
     */
    private $merchantId;

    /**
     * ???????
     *
     * @Column(name="trade_no", prop="tradeNo")
     *
     * @var string
     */
    private $tradeNo;

    /**
     * ????????
     *
     * @Column(name="out_trade_no", prop="outTradeNo")
     *
     * @var string
     */
    private $outTradeNo;

    /**
     * ????
     *
     * @Column(name="order_amount", prop="orderAmount")
     *
     * @var float
     */
    private $orderAmount;

    /**
     * ????
     *
     * @Column(name="discount_amount", prop="discountAmount")
     *
     * @var float
     */
    private $discountAmount;

    /**
     * ??????
     *
     * @Column(name="final_amount", prop="finalAmount")
     *
     * @var float
     */
    private $finalAmount;

    /**
     * ????
     *
     * @Column(name="pay_time", prop="payTime")
     *
     * @var string|null
     */
    private $payTime;

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
     * @param int $userId
     *
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param int $merchantId
     *
     * @return void
     */
    public function setMerchantId(int $merchantId): void
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @param string $tradeNo
     *
     * @return void
     */
    public function setTradeNo(string $tradeNo): void
    {
        $this->tradeNo = $tradeNo;
    }

    /**
     * @param string $outTradeNo
     *
     * @return void
     */
    public function setOutTradeNo(string $outTradeNo): void
    {
        $this->outTradeNo = $outTradeNo;
    }

    /**
     * @param float $orderAmount
     *
     * @return void
     */
    public function setOrderAmount(float $orderAmount): void
    {
        $this->orderAmount = $orderAmount;
    }

    /**
     * @param float $discountAmount
     *
     * @return void
     */
    public function setDiscountAmount(float $discountAmount): void
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * @param float $finalAmount
     *
     * @return void
     */
    public function setFinalAmount(float $finalAmount): void
    {
        $this->finalAmount = $finalAmount;
    }

    /**
     * @param string|null $payTime
     *
     * @return void
     */
    public function setPayTime(?string $payTime): void
    {
        $this->payTime = $payTime;
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
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getMerchantId(): ?int
    {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getTradeNo(): ?string
    {
        return $this->tradeNo;
    }

    /**
     * @return string
     */
    public function getOutTradeNo(): ?string
    {
        return $this->outTradeNo;
    }

    /**
     * @return float
     */
    public function getOrderAmount(): ?float
    {
        return $this->orderAmount;
    }

    /**
     * @return float
     */
    public function getDiscountAmount(): ?float
    {
        return $this->discountAmount;
    }

    /**
     * @return float
     */
    public function getFinalAmount(): ?float
    {
        return $this->finalAmount;
    }

    /**
     * @return string|null
     */
    public function getPayTime(): ?string
    {
        return $this->payTime;
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
