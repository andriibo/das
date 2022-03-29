<?php

namespace App\Enums;

enum CricketGameScheduleTypeEnum: string
{
    case t20 = 'T20';

    case odi = 'ODI';

    case test = 'TEST';

    case firstClass = 'First-class';
}
