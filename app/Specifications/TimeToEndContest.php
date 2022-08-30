<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class TimeToEndContest
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return time() >= strtotime($contest->end_date);
    }
}
