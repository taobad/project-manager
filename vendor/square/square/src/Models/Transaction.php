<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a transaction processed with Square, either with the
 * Connect API or with Square Point of Sale.
 *
 * The `tenders` field of this object lists all methods of payment used to pay in
 * the transaction.
 */
class Transaction implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var Tender[]|null
     */
    private $tenders;

    /**
     * @var Refund[]|null
     */
    private $refunds;

    /**
     * @var string|null
     */
    private $referenceId;

    /**
     * @var string|null
     */
    private $product;

    /**
     * @var string|null
     */
    private $clientId;

    /**
     * @var Address|null
     */
    private $shippingAddress;

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * Returns Id.
     *
     * The transaction's unique ID, issued by Square payments servers.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * The transaction's unique ID, issued by Square payments servers.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Location Id.
     *
     * The ID of the transaction's associated location.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     *
     * The ID of the transaction's associated location.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Created At.
     *
     * The timestamp for when the transaction was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * The timestamp for when the transaction was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Tenders.
     *
     * The tenders used to pay in the transaction.
     *
     * @return Tender[]|null
     */
    public function getTenders(): ?array
    {
        return $this->tenders;
    }

    /**
     * Sets Tenders.
     *
     * The tenders used to pay in the transaction.
     *
     * @maps tenders
     *
     * @param Tender[]|null $tenders
     */
    public function setTenders(?array $tenders): void
    {
        $this->tenders = $tenders;
    }

    /**
     * Returns Refunds.
     *
     * Refunds that have been applied to any tender in the transaction.
     *
     * @return Refund[]|null
     */
    public function getRefunds(): ?array
    {
        return $this->refunds;
    }

    /**
     * Sets Refunds.
     *
     * Refunds that have been applied to any tender in the transaction.
     *
     * @maps refunds
     *
     * @param Refund[]|null $refunds
     */
    public function setRefunds(?array $refunds): void
    {
        $this->refunds = $refunds;
    }

    /**
     * Returns Reference Id.
     *
     * If the transaction was created with the [Charge](#endpoint-charge)
     * endpoint, this value is the same as the value provided for the `reference_id`
     * parameter in the request to that endpoint. Otherwise, it is not set.
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * Sets Reference Id.
     *
     * If the transaction was created with the [Charge](#endpoint-charge)
     * endpoint, this value is the same as the value provided for the `reference_id`
     * parameter in the request to that endpoint. Otherwise, it is not set.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * Returns Product.
     *
     * Indicates the Square product used to process a transaction.
     */
    public function getProduct(): ?string
    {
        return $this->product;
    }

    /**
     * Sets Product.
     *
     * Indicates the Square product used to process a transaction.
     *
     * @maps product
     */
    public function setProduct(?string $product): void
    {
        $this->product = $product;
    }

    /**
     * Returns Client Id.
     *
     * If the transaction was created in the Square Point of Sale app, this value
     * is the ID generated for the transaction by Square Point of Sale.
     *
     * This ID has no relationship to the transaction's canonical `id`, which is
     * generated by Square's backend servers. This value is generated for bookkeeping
     * purposes, in case the transaction cannot immediately be completed (for example,
     * if the transaction is processed in offline mode).
     *
     * It is not currently possible with the Connect API to perform a transaction
     * lookup by this value.
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * Sets Client Id.
     *
     * If the transaction was created in the Square Point of Sale app, this value
     * is the ID generated for the transaction by Square Point of Sale.
     *
     * This ID has no relationship to the transaction's canonical `id`, which is
     * generated by Square's backend servers. This value is generated for bookkeeping
     * purposes, in case the transaction cannot immediately be completed (for example,
     * if the transaction is processed in offline mode).
     *
     * It is not currently possible with the Connect API to perform a transaction
     * lookup by this value.
     *
     * @maps client_id
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * Returns Shipping Address.
     *
     * Represents a physical address.
     */
    public function getShippingAddress(): ?Address
    {
        return $this->shippingAddress;
    }

    /**
     * Sets Shipping Address.
     *
     * Represents a physical address.
     *
     * @maps shipping_address
     */
    public function setShippingAddress(?Address $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Returns Order Id.
     *
     * The order_id is an identifier for the order associated with this transaction, if any.
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     *
     * The order_id is an identifier for the order associated with this transaction, if any.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']              = $this->id;
        $json['location_id']     = $this->locationId;
        $json['created_at']      = $this->createdAt;
        $json['tenders']         = $this->tenders;
        $json['refunds']         = $this->refunds;
        $json['reference_id']    = $this->referenceId;
        $json['product']         = $this->product;
        $json['client_id']       = $this->clientId;
        $json['shipping_address'] = $this->shippingAddress;
        $json['order_id']        = $this->orderId;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
