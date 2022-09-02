<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class TimeToStartContestSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return time() >= strtotime($contest->start_date);
    }
}
