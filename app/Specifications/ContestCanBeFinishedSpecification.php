<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeFinishedSpecification
{
    public function __construct(
        private readonly ContestStatusAllowsFinish $contestStatusAllowsFinish,
        private readonly AllContestGamesHaveFinalBox $allContestGamesHaveFinalBox,
        private readonly ContestGameScheduleDidNotChange $contestGameScheduleDidNotChange
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if (!$this->contestStatusAllowsFinish->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->allContestGamesHaveFinalBox->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameScheduleDidNotChange->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
