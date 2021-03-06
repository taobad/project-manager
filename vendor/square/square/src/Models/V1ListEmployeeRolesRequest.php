<?php

declare(strict_types=1);

namespace Square\Models;

class V1ListEmployeeRolesRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $order;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $batchToken;

    /**
     * Returns Order.
     *
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * Sets Order.
     *
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps order
     */
    public function setOrder(?string $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Limit.
     *
     * The maximum integer number of employee entities to return in a single response. Default 100, maximum
     * 200.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     *
     * The maximum integer number of employee entities to return in a single response. Default 100, maximum
     * 200.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Batch Token.
     *
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint.
     */
    public function getBatchToken(): ?string
    {
        return $this->batchToken;
    }

    /**
     * Sets Batch Token.
     *
     * A pagination cursor to retrieve the next set of results for your
     * original query to the endpoint.
     *
     * @maps batch_token
     */
    public function setBatchToken(?string $batchToken): void
    {
        $this->batchToken = $batchToken;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['order']      = $this->order;
        $json['limit']      = $this->limit;
        $json['batch_token'] = $this->batchToken;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
