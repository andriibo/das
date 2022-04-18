<?php

namespace App\Enums\CricketGameSchedule;

use ArchTech\Enums\Values;

enum TypeEnum: string
{
    use Values;

    case t20 = 'T20';

    case odi = 'ODI';

    case test = 'Test';

    case firstClass = 'First-class';
}
