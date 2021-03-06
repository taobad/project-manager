<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A request to search for loyalty events.
 */
class SearchLoyaltyEventsRequest implements \JsonSerializable
{
    /**
     * @var LoyaltyEventQuery|null
     */
    private $query;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Query.
     *
     * Represents a query used to search for loyalty events.
     */
    public function getQuery(): ?LoyaltyEventQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     *
     * Represents a query used to search for loyalty events.
     *
     * @maps query
     */
    public function setQuery(?LoyaltyEventQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     *
     * The maximum number of results to include in the response.
     * The last page might contain fewer events.
     * The default is 30 events.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     *
     * The maximum number of results to include in the response.
     * The last page might contain fewer events.
     * The default is 30 events.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Returns Cursor.
     *
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     * For more information, see [Pagination](https://developer.squareup.
     * com/docs/docs/basics/api101/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     *
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     * For more information, see [Pagination](https://developer.squareup.
     * com/docs/docs/basics/api101/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['query']  = $this->query;
        $json['limit']  = $this->limit;
        $json['cursor'] = $this->cursor;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
