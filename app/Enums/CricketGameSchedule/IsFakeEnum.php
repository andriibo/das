<?php

namespace App\Enums\CricketGameSchedule;

use ArchTech\Enums\Values;

enum IsFakeEnum: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
