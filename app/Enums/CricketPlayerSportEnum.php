<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum CricketPlayerSportEnum
{
    use Names;

    case soccer;

    case football;

    case cricket;
}
