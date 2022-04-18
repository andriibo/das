<?php

namespace App\Enums\CricketPlayer;

use ArchTech\Enums\Names;

enum SportEnum
{
    use Names;

    case soccer;

    case football;

    case cricket;
}
