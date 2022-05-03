<?php

namespace App\Mappers;

use App\Dto\CricketGameLogDto;

class CricketGameLogMapper
{
    public function map(array $data): CricketGameLogDto
    {
        $cricketGameLogDto = new CricketGameLogDto();

        $cricketGameLogDto->gameScheduleId = $data['game_schedule_id'];
        $cricketGameLogDto->unitId = $data['unit_id'];
        $cricketGameLogDto->actionPointId = $data['action_point_id'];
        $cricketGameLogDto->value = $data['value'];

        return $cricketGameLogDto;
    }
}
