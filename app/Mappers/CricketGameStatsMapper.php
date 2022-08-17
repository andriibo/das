<?php

namespace App\Mappers;

use App\Dto\CricketGameStatsDto;

class CricketGameStatsMapper
{
    public function map(array $data, int $gameScheduleId): CricketGameStatsDto
    {
        $cricketUnitStatsDto = new CricketGameStatsDto();

        $cricketUnitStatsDto->gameScheduleId = $gameScheduleId;
        $cricketUnitStatsDto->rawStats = $data;

        return $cricketUnitStatsDto;
    }
}
