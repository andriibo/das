<?php

namespace App\Mappers;

use App\Dto\CricketUnitStatsDto;
use App\Services\CricketPlayerService;

class CricketUnitStatsMapper
{
    public function __construct(private readonly CricketPlayerService $cricketPlayerService)
    {
    }

    public function map(array $data): CricketUnitStatsDto
    {
        $cricketUnitStatDto = new CricketUnitStatsDto();

        $cricketUnitStatDto->gameScheduleId = $data['game_id'];
        $cricketUnitStatDto->playerId = $this->getPlayerIdByFeedId($data['profile_id']);
        $cricketUnitStatDto->teamId = $data['team_id'];
        $cricketUnitStatDto->rawStats = $data['stats'];

        return $cricketUnitStatDto;
    }

    private function getPlayerIdByFeedId(string $feedId): int
    {
        return $this->cricketPlayerService->getCricketPlayerByFeedId($feedId)->id;
    }
}
