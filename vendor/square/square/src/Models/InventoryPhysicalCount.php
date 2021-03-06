<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents the quantity of an item variation that is physically present
 * at a specific location, verified by a seller or a seller's employee. For example,
 * a physical count might come from an employee counting the item variations on
 * hand or from syncing with an external system.
 */
class InventoryPhysicalCount implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $referenceId;

    /**
     * @var string|null
     */
    private $catalogObjectId;

    /**
     * @var string|null
     */
    private $catalogObjectType;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var string|null
     */
    private $quantity;

    /**
     * @var SourceApplication|null
     */
    private $source;

    /**
     * @var string|null
     */
    private $employeeId;

    /**
     * @var string|null
     */
    private $occurredAt;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * Returns Id.
     *
     * A unique ID generated by Square for the
     * [InventoryPhysicalCount](#type-inventoryphysicalcount).
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * A unique ID generated by Square for the
     * [InventoryPhysicalCount](#type-inventoryphysicalcount).
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Reference Id.
     *
     * An optional ID provided by the application to tie the
     * [InventoryPhysicalCount](#type-inventoryphysicalcount) to an external
     * system.
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * Sets Reference Id.
     *
     * An optional ID provided by the application to tie the
     * [InventoryPhysicalCount](#type-inventoryphysicalcount) to an external
     * system.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * Returns Catalog Object Id.
     *
     * The Square generated ID of the
     * `CatalogObject` being tracked.
     */
    public function getCatalogObjectId(): ?string
    {
        return $this->catalogObjectId;
    }

    /**
     * Sets Catalog Object Id.
     *
     * The Square generated ID of the
     * `CatalogObject` being tracked.
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId = $catalogObjectId;
    }

    /**
     * Returns Catalog Object Type.
     *
     * The `CatalogObjectType` of the
     * `CatalogObject` being tracked. Tracking is only
     * supported for the `ITEM_VARIATION` type.
     */
    public function getCatalogObjectType(): ?string
    {
        return $this->catalogObjectType;
    }

    /**
     * Sets Catalog Object Type.
     *
     * The `CatalogObjectType` of the
     * `CatalogObject` being tracked. Tracking is only
     * supported for the `ITEM_VARIATION` type.
     *
     * @maps catalog_object_type
     */
    public function setCatalogObjectType(?string $catalogObjectType): void
    {
        $this->catalogObjectType = $catalogObjectType;
    }

    /**
     * Returns State.
     *
     * Indicates the state of a tracked item quantity in the lifecycle of goods.
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets State.
     *
     * Indicates the state of a tracked item quantity in the lifecycle of goods.
     *
     * @maps state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * Returns Location Id.
     *
     * The Square ID of the [Location](#type-location) where the related
     * quantity of items are being tracked.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     *
     * The Square ID of the [Location](#type-location) where the related
     * quantity of items are being tracked.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Quantity.
     *
     * The number of items affected by the physical count as a decimal string.
     * Can support up to 5 digits after the decimal point.
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * Sets Quantity.
     *
     * The number of items affected by the physical count as a decimal string.
     * Can support up to 5 digits after the decimal point.
     *
     * @maps quantity
     */
    public function setQuantity(?string $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Returns Source.
     *
     * Provides information about the application used to generate a change.
     */
    public function getSource(): ?SourceApplication
    {
        return $this->source;
    }

    /**
     * Sets Source.
     *
     * Provides information about the application used to generate a change.
     *
     * @maps source
     */
    public function setSource(?SourceApplication $source): void
    {
        $this->source = $source;
    }

    /**
     * Returns Employee Id.
     *
     * The Square ID of the [Employee](#type-employee) responsible for the
     * physical count.
     */
    public function getEmployeeId(): ?string
    {
        return $this->employeeId;
    }

    /**
     * Sets Employee Id.
     *
     * The Square ID of the [Employee](#type-employee) responsible for the
     * physical count.
     *
     * @maps employee_id
     */
    public function setEmployeeId(?string $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    /**
     * Returns Occurred At.
     *
     * A client-generated timestamp in RFC 3339 format that indicates when
     * the physical count took place. For write actions, the `occurred_at`
     * timestamp cannot be older than 24 hours or in the future relative to the
     * time of the request.
     */
    public function getOccurredAt(): ?string
    {
        return $this->occurredAt;
    }

    /**
     * Sets Occurred At.
     *
     * A client-generated timestamp in RFC 3339 format that indicates when
     * the physical count took place. For write actions, the `occurred_at`
     * timestamp cannot be older than 24 hours or in the future relative to the
     * time of the request.
     *
     * @maps occurred_at
     */
    public function setOccurredAt(?string $occurredAt): void
    {
        $this->occurredAt = $occurredAt;
    }

    /**
     * Returns Created At.
     *
     * A read-only timestamp in RFC 3339 format that indicates when Square
     * received the physical count.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * A read-only timestamp in RFC 3339 format that indicates when Square
     * received the physical count.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']                = $this->id;
        $json['reference_id']      = $this->referenceId;
        $json['catalog_object_id'] = $this->catalogObjectId;
        $json['catalog_object_type'] = $this->catalogObjectType;
        $json['state']             = $this->state;
        $json['location_id']       = $this->locationId;
        $json['quantity']          = $this->quantity;
        $json['source']            = $this->source;
        $json['employee_id']       = $this->employeeId;
        $json['occurred_at']       = $this->occurredAt;
        $json['created_at']        = $this->createdAt;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
