<?php

namespace App\Enums\UserTransactions;

use ArchTech\Enums\Values;

enum StatusEnum: int
{
    use Values;

    case new = 0;

    case success = 1;

    case declined = 2;

    case cancelled = 3;

    case returnedBonus = 4;

    case approved = 5;
}
