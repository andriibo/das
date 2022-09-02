<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeCancelledSpecification
{
    public function __construct(
        private readonly TimeToStartContestSpecification $timeToStartContestSpecification,
        private readonly TimeToEndContestSpecification $timeToEndContestSpecification,
        private readonly ContestGameSchedulesCountChangedSpecification $contestGameSchedulesCountChangedSpecification,
        private readonly ContestStatusAllowsStartSpecification $contestStatusAllowsStartSpecification,
        private readonly ContestHasEnoughUsersSpecification $contestHasEnoughUsersSpecification
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($contest->isSuspended()
            && $this->timeToStartContestSpecification->isSatisfiedBy($contest)
            && $this->timeToEndContestSpecification->isSatisfiedBy($contest)) {
            return true;
        }
        if ($contest->isSuspended()) {
            return false;
        }
        if (!$this->contestGameSchedulesCountChangedSpecification->isSatisfiedBy($contest)) {
            return true;
        }
        if ($this->contestStatusAllowsStartSpecification->isSatisfiedBy($contest)
            && $this->timeToStartContestSpecification->isSatisfiedBy($contest)
            && !$this->contestHasEnoughUsersSpecification->isSatisfiedBy($contest)) {
            return true;
        }

        return false;
    }
}
