<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a response from a search request, containing a filtered list of `TeamMember` objects.
 */
class SearchTeamMembersResponse implements \JsonSerializable
{
    /**
     * @var TeamMember[]|null
     */
    private $teamMembers;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Team Members.
     *
     * The filtered list of `TeamMember` objects.
     *
     * @return TeamMember[]|null
     */
    public function getTeamMembers(): ?array
    {
        return $this->teamMembers;
    }

    /**
     * Sets Team Members.
     *
     * The filtered list of `TeamMember` objects.
     *
     * @maps team_members
     *
     * @param TeamMember[]|null $teamMembers
     */
    public function setTeamMembers(?array $teamMembers): void
    {
        $this->teamMembers = $teamMembers;
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
     * Returns Errors.
     *
     * The errors that occurred during the request.
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
     * The errors that occurred during the request.
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
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['team_members'] = $this->teamMembers;
        $json['cursor']      = $this->cursor;
        $json['errors']      = $this->errors;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
