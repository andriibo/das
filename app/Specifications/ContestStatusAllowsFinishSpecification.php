<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsFinishSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->status === StatusEnum::started->value && !$contest->isSuspended();
    }
}
