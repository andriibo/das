<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum GameTypeEnum: string
{
    use Values;

    case salary = 'salary';

    case pointSpread = 'point-spread';
}
