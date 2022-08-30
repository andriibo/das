<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class TimeToStartContest
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return time() >= strtotime($contest->start_date);
    }
}
