<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A request to create a loyalty reward.
 */
class CreateLoyaltyRewardRequest implements \JsonSerializable
{
    /**
     * @var LoyaltyReward
     */
    private $reward;

    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @param LoyaltyReward $reward
     * @param string $idempotencyKey
     */
    public function __construct(LoyaltyReward $reward, string $idempotencyKey)
    {
        $this->reward = $reward;
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Reward.
     */
    public function getReward(): LoyaltyReward
    {
        return $this->reward;
    }

    /**
     * Sets Reward.
     *
     * @required
     * @maps reward
     */
    public function setReward(LoyaltyReward $reward): void
    {
        $this->reward = $reward;
    }

    /**
     * Returns Idempotency Key.
     *
     * A unique string that identifies this `CreateLoyaltyReward` request.
     * Keys can be any valid string, but must be unique for every request.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     *
     * A unique string that identifies this `CreateLoyaltyReward` request.
     * Keys can be any valid string, but must be unique for every request.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['reward']         = $this->reward;
        $json['idempotency_key'] = $this->idempotencyKey;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
