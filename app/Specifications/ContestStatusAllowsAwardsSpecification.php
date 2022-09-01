<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsAwardsSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return in_array($contest->status, [StatusEnum::finished->value, StatusEnum::closed->value]);
    }
}
