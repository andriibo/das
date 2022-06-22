<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum IsPrizeBankInPercents: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
