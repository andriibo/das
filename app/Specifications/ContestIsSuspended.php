<?php

namespace App\Specifications;

use App\Enums\Contests\SuspendedEnum;
use App\Models\Contests\Contest;

class ContestIsSuspended
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->suspended === SuspendedEnum::yes->value;
    }
}
