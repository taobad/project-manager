<?php

declare(strict_types=1);

namespace Square\Models;

class LoyaltyReward implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string
     */
    private $loyaltyAccountId;

    /**
     * @var string
     */
    private $rewardTierId;

    /**
     * @var int|null
     */
    private $points;

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var string|null
     */
    private $redeemedAt;

    /**
     * @param string $loyaltyAccountId
     * @param string $rewardTierId
     */
    public function __construct(string $loyaltyAccountId, string $rewardTierId)
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
        $this->rewardTierId = $rewardTierId;
    }

    /**
     * Returns Id.
     *
     * The Square-assigned ID of the loyalty reward.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * The Square-assigned ID of the loyalty reward.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Status.
     *
     * The status of the loyalty reward.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     *
     * The status of the loyalty reward.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Loyalty Account Id.
     *
     * The Square-assigned ID of the [loyalty account](#type-LoyaltyAccount) to which the reward belongs.
     */
    public function getLoyaltyAccountId(): string
    {
        return $this->loyaltyAccountId;
    }

    /**
     * Sets Loyalty Account Id.
     *
     * The Square-assigned ID of the [loyalty account](#type-LoyaltyAccount) to which the reward belongs.
     *
     * @required
     * @maps loyalty_account_id
     */
    public function setLoyaltyAccountId(string $loyaltyAccountId): void
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
    }

    /**
     * Returns Reward Tier Id.
     *
     * The Square-assigned ID of the [reward tier](#type-LoyaltyProgramRewardTier) used to create the
     * reward.
     */
    public function getRewardTierId(): string
    {
        return $this->rewardTierId;
    }

    /**
     * Sets Reward Tier Id.
     *
     * The Square-assigned ID of the [reward tier](#type-LoyaltyProgramRewardTier) used to create the
     * reward.
     *
     * @required
     * @maps reward_tier_id
     */
    public function setRewardTierId(string $rewardTierId): void
    {
        $this->rewardTierId = $rewardTierId;
    }

    /**
     * Returns Points.
     *
     * The number of loyalty points used for the reward.
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     *
     * The number of loyalty points used for the reward.
     *
     * @maps points
     */
    public function setPoints(?int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Order Id.
     *
     * The Square-assigned ID of the [order](#type-Order) to which the reward is attached.
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     *
     * The Square-assigned ID of the [order](#type-Order) to which the reward is attached.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * Returns Created At.
     *
     * The timestamp when the reward was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * The timestamp when the reward was created, in RFC 3339 format.
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
     * The timestamp when the reward was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     *
     * The timestamp when the reward was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Redeemed At.
     *
     * The timestamp when the reward was redeemed, in RFC 3339 format.
     */
    public function getRedeemedAt(): ?string
    {
        return $this->redeemedAt;
    }

    /**
     * Sets Redeemed At.
     *
     * The timestamp when the reward was redeemed, in RFC 3339 format.
     *
     * @maps redeemed_at
     */
    public function setRedeemedAt(?string $redeemedAt): void
    {
        $this->redeemedAt = $redeemedAt;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']               = $this->id;
        $json['status']           = $this->status;
        $json['loyalty_account_id'] = $this->loyaltyAccountId;
        $json['reward_tier_id']   = $this->rewardTierId;
        $json['points']           = $this->points;
        $json['order_id']         = $this->orderId;
        $json['created_at']       = $this->createdAt;
        $json['updated_at']       = $this->updatedAt;
        $json['redeemed_at']      = $this->redeemedAt;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
