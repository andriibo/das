<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;

class ContestCanBeStartedSpecification
{
    public function __construct(
        private readonly ContestStatusAllowsStartSpecification $contestStatusAllowsStartSpecification,
        private readonly TimeToStartContestSpecification $timeToStartContestSpecification,
        private readonly ContestHasEnoughUsersSpecification $contestHasEnoughUsersSpecification,
        private readonly ContestGameSchedulesCountChangedSpecification $contestGameSchedulesCountChangedSpecification
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        if (!$this->contestStatusAllowsStartSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->timeToStartContestSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestHasEnoughUsersSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestGameSchedulesCountChangedSpecification->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
