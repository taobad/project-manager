<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the fields that are included in the response from the
 * [CreateSubscription](#endpoint-subscriptions-createsubscription) endpoint.
 */
class CreateSubscriptionResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Subscription|null
     */
    private $subscription;

    /**
     * Returns Errors.
     *
     * Information about errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     *
     * Information about errors encountered during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Subscription.
     *
     * Represents a customer subscription to a subscription plan.
     * For an overview of the `Subscription` type, see
     * [Subscription object](https://developer.squareup.com/docs/docs/subscriptions-
     * api/overview#subscription-object-overview).
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * Sets Subscription.
     *
     * Represents a customer subscription to a subscription plan.
     * For an overview of the `Subscription` type, see
     * [Subscription object](https://developer.squareup.com/docs/docs/subscriptions-
     * api/overview#subscription-object-overview).
     *
     * @maps subscription
     */
    public function setSubscription(?Subscription $subscription): void
    {
        $this->subscription = $subscription;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors']       = $this->errors;
        $json['subscription'] = $this->subscription;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
