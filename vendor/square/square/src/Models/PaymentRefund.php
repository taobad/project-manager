<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a refund of a payment made using Square. Contains information on
 * the original payment and the amount of money refunded.
 */
class PaymentRefund implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var Money|null
     */
    private $appFeeMoney;

    /**
     * @var ProcessingFee[]|null
     */
    private $processingFee;

    /**
     * @var string|null
     */
    private $paymentId;

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @param string $id
     * @param Money $amountMoney
     */
    public function __construct(string $id, Money $amountMoney)
    {
        $this->id = $id;
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Id.
     *
     * Unique ID for this refund, generated by Square.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * Unique ID for this refund, generated by Square.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Status.
     *
     * The refund's status:
     * - `PENDING` - awaiting approval
     * - `COMPLETED` - successfully completed
     * - `REJECTED` - the refund was rejected
     * - `FAILED` - an error occurred
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     *
     * The refund's status:
     * - `PENDING` - awaiting approval
     * - `COMPLETED` - successfully completed
     * - `REJECTED` - the refund was rejected
     * - `FAILED` - an error occurred
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Location Id.
     *
     * Location ID associated with the payment this refund is attached to.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     *
     * Location ID associated with the payment this refund is attached to.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Amount Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAmountMoney(): Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @required
     * @maps amount_money
     */
    public function setAmountMoney(Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns App Fee Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAppFeeMoney(): ?Money
    {
        return $this->appFeeMoney;
    }

    /**
     * Sets App Fee Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps app_fee_money
     */
    public function setAppFeeMoney(?Money $appFeeMoney): void
    {
        $this->appFeeMoney = $appFeeMoney;
    }

    /**
     * Returns Processing Fee.
     *
     * Processing fees and fee adjustments assessed by Square on this refund.
     *
     * @return ProcessingFee[]|null
     */
    public function getProcessingFee(): ?array
    {
        return $this->processingFee;
    }

    /**
     * Sets Processing Fee.
     *
     * Processing fees and fee adjustments assessed by Square on this refund.
     *
     * @maps processing_fee
     *
     * @param ProcessingFee[]|null $processingFee
     */
    public function setProcessingFee(?array $processingFee): void
    {
        $this->processingFee = $processingFee;
    }

    /**
     * Returns Payment Id.
     *
     * The ID of the payment assocated with this refund.
     */
    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    /**
     * Sets Payment Id.
     *
     * The ID of the payment assocated with this refund.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    /**
     * Returns Order Id.
     *
     * The ID of the order associated with the refund.
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     *
     * The ID of the order associated with the refund.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * Returns Reason.
     *
     * The reason for the refund.
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * Sets Reason.
     *
     * The reason for the refund.
     *
     * @maps reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * Returns Created At.
     *
     * Timestamp of when the refund was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * Timestamp of when the refund was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     *
     * Timestamp of when the refund was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     *
     * Timestamp of when the refund was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']            = $this->id;
        $json['status']        = $this->status;
        $json['location_id']   = $this->locationId;
        $json['amount_money']  = $this->amountMoney;
        $json['app_fee_money'] = $this->appFeeMoney;
        $json['processing_fee'] = $this->processingFee;
        $json['payment_id']    = $this->paymentId;
        $json['order_id']      = $this->orderId;
        $json['reason']        = $this->reason;
        $json['created_at']    = $this->createdAt;
        $json['updated_at']    = $this->updatedAt;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
