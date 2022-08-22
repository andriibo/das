<?php

namespace App\Services\Cricket;

use App\Enums\CricketUnit\PositionEnum;

class GetCricketUnitPositionService
{
    public function handle(string $position): PositionEnum
    {
        if ($position === 'Bowling allrounder') {
            return PositionEnum::battingAllrounder;
        }

        return PositionEnum::tryFrom($position);
    }
}
