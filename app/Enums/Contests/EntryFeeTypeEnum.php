<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum EntryFeeTypeEnum: int
{
    use Values;

    case money = 1;

    case voucher = 2;

    case ticket = 4;
}
