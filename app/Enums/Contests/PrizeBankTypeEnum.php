<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum PrizeBankTypeEnum: int
{
    use Values;

    case wta = 1;

    case topThree = 2;

    case fiftyFifty = 3;

    case customPayout = 4;
}
