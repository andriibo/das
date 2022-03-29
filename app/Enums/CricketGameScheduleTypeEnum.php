<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum CricketGameScheduleTypeEnum: string
{
    use Values;

    case t20 = 'T20';

    case odi = 'ODI';

    case test = 'Test';

    case firstClass = 'First-class';
}
