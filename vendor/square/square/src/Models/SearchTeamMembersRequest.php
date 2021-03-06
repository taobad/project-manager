<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a search request for a filtered list of `TeamMember` objects.
 */
class SearchTeamMembersRequest implements \JsonSerializable
{
    /**
     * @var SearchTeamMembersQuery|null
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
     * Represents the parameters in a search for `TeamMember` objects.
     */
    public function getQuery(): ?SearchTeamMembersQuery
    {
        return $this->query;
    }

    /**
     * Sets Query.
     *
     * Represents the parameters in a search for `TeamMember` objects.
     *
     * @maps query
     */
    public function setQuery(?SearchTeamMembersQuery $query): void
    {
        $this->query = $query;
    }

    /**
     * Returns Limit.
     *
     * The maximum number of `TeamMember` objects in a page (25 by default).
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets Limit.
     *
     * The maximum number of `TeamMember` objects in a page (25 by default).
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
     * The opaque cursor for fetching the next page. Read about
     * [pagination](https://developer.squareup.com/docs/docs/working-with-apis/pagination) with Square APIs
     * for more information.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     *
     * The opaque cursor for fetching the next page. Read about
     * [pagination](https://developer.squareup.com/docs/docs/working-with-apis/pagination) with Square APIs
     * for more information.
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
