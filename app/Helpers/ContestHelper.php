<?php

namespace App\Helpers;

use App\Enums\Contests\ContestTypeEnum;

class ContestHelper
{
    public static function getContestTypes(): array
    {
        return [
            ContestTypeEnum::wta->value => 'Featured',
            ContestTypeEnum::topThree->value => 'Top Three',
            ContestTypeEnum::fiftyFifty->value => '50/50',
            ContestTypeEnum::headToHead->value => 'H2H',
            ContestTypeEnum::custom->value => 'Custom',
        ];
    }
}
