<?php

declare(strict_types=1);

namespace Square\Models;

class V1ListLocationsResponse implements \JsonSerializable
{
    /**
     * @var V1Merchant[]|null
     */
    private $items;

    /**
     * Returns Items.
     *
     * @return V1Merchant[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Sets Items.
     *
     * @maps items
     *
     * @param V1Merchant[]|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['items'] = $this->items;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
