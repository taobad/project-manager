<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Enumerates the possible assignment types the team member can have
 */
class TeamMemberAssignedLocationsAssignmentType
{
    /**
     * The team member is assigned to all curent and future locations - the location_ids field
     * is empty if the team member has this assignment type.
     */
    public const ALL_CURRENT_AND_FUTURE_LOCATIONS = 'ALL_CURRENT_AND_FUTURE_LOCATIONS';

    /**
     * The team member is assigned to an explicit subset of locations - the location_ids field
     * is the list of locations that the team member is assigned to.
     */
    public const EXPLICIT_LOCATIONS = 'EXPLICIT_LOCATIONS';
}
