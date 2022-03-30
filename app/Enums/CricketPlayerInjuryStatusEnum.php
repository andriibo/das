<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum CricketPlayerInjuryStatusEnum
{
    use Names;

    case normal;

    case out;

    case possible;
}
