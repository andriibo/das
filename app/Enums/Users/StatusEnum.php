<?php

namespace App\Enums\Users;

use ArchTech\Enums\Values;

enum StatusEnum: int
{
    use Values;

    case deleted = 0;

    case notActive = 1;

    case active = 10;
}
