<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeCancelledSpecification
{
    public function __construct(
        private readonly ContestIsSuspended $contestIsSuspended,
        private readonly TimeToStartContest $timeToStartContest,
        private readonly TimeToEndContest $timeToEndContest,
        private readonly ContestGameScheduleDidNotChange $contestGameScheduleDidNotChange,
        private readonly ContestStatusAllowsStart $contestStatusAllowsStart,
        private readonly ContestHasEnoughUsers $contestHasEnoughUsers
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($this->contestIsSuspended->isSatisfiedBy($contest)
            && $this->timeToStartContest->isSatisfiedBy($contest)
            && $this->timeToEndContest->isSatisfiedBy($contest)) {
            return true;
        }
        if ($this->contestIsSuspended->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameScheduleDidNotChange->isSatisfiedBy($contest)) {
            return true;
        }
        if ($this->contestStatusAllowsStart->isSatisfiedBy($contest)
            && $this->timeToStartContest->isSatisfiedBy($contest)
            && !$this->contestHasEnoughUsers->isSatisfiedBy($contest)) {
            return true;
        }

        return false;
    }
}
