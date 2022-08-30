<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeStartedSpecification
{
    public function __construct(
        private readonly ContestStatusAllowsStart $contestStatusAllowsStart,
        private readonly TimeToStartContest $timeToStartContest,
        private readonly ContestHasEnoughUsers $contestHasEnoughUsers,
        private readonly ContestGameScheduleDidNotChange $contestGameScheduleDidNotChange
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if (!$this->contestStatusAllowsStart->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->timeToStartContest->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestHasEnoughUsers->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameScheduleDidNotChange->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
