<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsStartSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->status === StatusEnum::ready->value && !$contest->isSuspended();
    }
}
