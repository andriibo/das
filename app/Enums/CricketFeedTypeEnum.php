<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum CricketFeedTypeEnum
{
    use Names;

    case fantasydata;

    case optafeed;

    case goalserve;

    case fantasydatacenter;
}
