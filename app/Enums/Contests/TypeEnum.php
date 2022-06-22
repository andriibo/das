<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Names;

enum TypeEnum
{
    use Names;

    case admin;

    case user;

    case template;
}
