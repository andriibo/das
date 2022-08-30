<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class ContestCanBeEntered
{
    public function __construct(
        private readonly ContestIsFull $contestIsFull,
        private readonly ContestStatusAllowsEntries $contestStatusAllowsEntries,
        private readonly TimeToStartContest $timeToStartContest
    ) {
    }

    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($this->contestIsFull->isSatisfiedBy($contest)) {
            return false;
        }
        if (!$this->contestStatusAllowsEntries->isSatisfiedBy($contest)) {
            return false;
        }
        if ($this->timeToStartContest->isSatisfiedBy($contest)) {
            return false;
        }

        return true;
    }
}
