<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeFinishedSpecification
{
    public function __construct(
        private readonly ContestStatusAllowsFinishSpecification $contestStatusAllowsFinishSpecification,
        private readonly AllContestGamesHaveFinalBoxSpecification $allContestGamesHaveFinalBoxSpecification,
        private readonly ContestGameSchedulesCountChangedSpecification $contestGameSchedulesCountChangedSpecification
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if (!$this->contestStatusAllowsFinishSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->allContestGamesHaveFinalBoxSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameSchedulesCountChangedSpecification->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
