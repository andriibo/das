<?php

namespace App\Enums\CricketPlayer;

use ArchTech\Enums\Names;

enum InjuryStatusEnum
{
    use Names;

    case normal;

    case out;

    case possible;
}
