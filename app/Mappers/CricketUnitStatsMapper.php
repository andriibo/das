<?php

namespace App\Mappers;

use App\Dto\CricketUnitStatsDto;
use App\Repositories\CricketUnitRepository;

class CricketUnitStatsMapper
{
    public function __construct(private readonly CricketUnitRepository $cricketUnitRepository)
    {
    }

    public function map(array $data): CricketUnitStatsDto
    {
        $cricketUnitStatDto = new CricketUnitStatsDto();
        $teamId = $data['team_id'];
        $cricketUnitStatDto->gameScheduleId = $data['game_id'];
        $cricketUnitStatDto->unitId = $this->getUnitId($data['player_id'], $teamId);
        $cricketUnitStatDto->teamId = $teamId;
        $cricketUnitStatDto->rawStats = $data['stats'];

        return $cricketUnitStatDto;
    }

    private function getUnitId(int $feedId, int $teamId): int
    {
        return $this->cricketUnitRepository->getByParams($feedId, $teamId)->id;
    }
}
