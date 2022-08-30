<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeClosedSpecification
{
    public function __construct(
        private readonly ContestStatusAllowsClose $contestStatusAllowsClose,
        private readonly ContestGameScheduleDidNotChange $contestGameScheduleDidNotChange,
        private readonly AllContestGamesAreFinalized $allContestGamesAreFinalized
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if (!$this->contestStatusAllowsClose->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameScheduleDidNotChange->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->allContestGamesAreFinalized->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
