<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents an applied portion of a tax to a line item in an order.
 *
 * Order-scoped taxes automatically include the applied taxes in each line item.
 * Line item taxes must be referenced from any applicable line items.
 * The corresponding applied money is automatically computed, based on the
 * set of participating line items.
 */
class OrderLineItemAppliedTax implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $uid;

    /**
     * @var string
     */
    private $taxUid;

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @param string $taxUid
     */
    public function __construct(string $taxUid)
    {
        $this->taxUid = $taxUid;
    }

    /**
     * Returns Uid.
     *
     * Unique ID that identifies the applied tax only within this order.
     */
    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * Sets Uid.
     *
     * Unique ID that identifies the applied tax only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * Returns Tax Uid.
     *
     * The `uid` of the tax for which this applied tax represents.  Must reference
     * a tax present in the `order.taxes` field.
     *
     * This field is immutable. To change which taxes apply to a line item, delete and add new
     * `OrderLineItemAppliedTax`s.
     */
    public function getTaxUid(): string
    {
        return $this->taxUid;
    }

    /**
     * Sets Tax Uid.
     *
     * The `uid` of the tax for which this applied tax represents.  Must reference
     * a tax present in the `order.taxes` field.
     *
     * This field is immutable. To change which taxes apply to a line item, delete and add new
     * `OrderLineItemAppliedTax`s.
     *
     * @required
     * @maps tax_uid
     */
    public function setTaxUid(string $taxUid): void
    {
        $this->taxUid = $taxUid;
    }

    /**
     * Returns Applied Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAppliedMoney(): ?Money
    {
        return $this->appliedMoney;
    }

    /**
     * Sets Applied Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps applied_money
     */
    public function setAppliedMoney(?Money $appliedMoney): void
    {
        $this->appliedMoney = $appliedMoney;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['uid']          = $this->uid;
        $json['tax_uid']      = $this->taxUid;
        $json['applied_money'] = $this->appliedMoney;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
