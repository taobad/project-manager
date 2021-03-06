<?php

declare(strict_types=1);

namespace Square\Models;

class CashDrawerDevice implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * Returns Id.
     *
     * The device Square-issued ID
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * The device Square-issued ID
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Name.
     *
     * The device merchant-specified name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * The device merchant-specified name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']   = $this->id;
        $json['name'] = $this->name;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
