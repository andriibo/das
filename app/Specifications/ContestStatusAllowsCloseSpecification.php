<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsCloseSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->status === StatusEnum::finished->value && !$contest->isSuspended();
    }
}
