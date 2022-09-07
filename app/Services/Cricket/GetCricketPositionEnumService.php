<?php

namespace App\Services\Cricket;

use App\Enums\CricketUnit\PositionEnum;

class GetCricketPositionEnumService
{
    public function handle(string $position): ?PositionEnum
    {
        if ($position === 'Allrounder') {
            return PositionEnum::bowlingAllrounder;
        }

        return PositionEnum::tryFrom(ucwords($position));
    }
}
