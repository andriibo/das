<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum PayoutTypeEnum: int
{
    use Values;

    case money = 1;

    case ticket = 2;

    case voucher = 4;
}
