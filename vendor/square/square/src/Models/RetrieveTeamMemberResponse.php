<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a response from a retrieve request, containing a `TeamMember` object or error messages.
 */
class RetrieveTeamMemberResponse implements \JsonSerializable
{
    /**
     * @var TeamMember|null
     */
    private $teamMember;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Team Member.
     *
     * A record representing an individual team member for a business.
     */
    public function getTeamMember(): ?TeamMember
    {
        return $this->teamMember;
    }

    /**
     * Sets Team Member.
     *
     * A record representing an individual team member for a business.
     *
     * @maps team_member
     */
    public function setTeamMember(?TeamMember $teamMember): void
    {
        $this->teamMember = $teamMember;
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
        $json['team_member'] = $this->teamMember;
        $json['errors']     = $this->errors;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
