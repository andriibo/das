<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeClosedSpecification
{
    public function __construct(
        private readonly ContestStatusAllowsCloseSpecification $contestStatusAllowsCloseSpecification,
        private readonly ContestGameSchedulesCountChangedSpecification $contestGameSchedulesCountChangedSpecification,
        private readonly AllContestGamesAreFinalizedSpecification $allContestGamesAreFinalizedSpecification
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if (!$this->contestStatusAllowsCloseSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameSchedulesCountChangedSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->allContestGamesAreFinalizedSpecification->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
