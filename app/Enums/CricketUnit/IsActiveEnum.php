<?php

namespace App\Enums\CricketUnit;

use ArchTech\Enums\Values;

enum IsActiveEnum: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
