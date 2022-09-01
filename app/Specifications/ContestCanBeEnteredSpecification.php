<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class ContestCanBeEnteredSpecification
{
    public function __construct(
        private readonly ContestIsFullSpecification $contestIsFullSpecification,
        private readonly ContestStatusAllowsStartSpecification $contestStatusAllowsStartSpecification,
        private readonly TimeToStartContestSpecification $timeToStartContestSpecification
    ) {
    }

    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($this->contestIsFullSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestStatusAllowsStartSpecification->isSatisfiedBy($contest)) {
            return false;
        }
        if ($this->timeToStartContestSpecification->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
