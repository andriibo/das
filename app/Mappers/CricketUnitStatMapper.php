<?php

namespace App\Mappers;

use App\Dto\CricketUnitStatDto;
use App\Services\CricketPlayerService;

class CricketUnitStatMapper
{
    public function __construct(private readonly CricketPlayerService $cricketPlayerService)
    {
    }

    public function map(array $data): CricketUnitStatDto
    {
        $cricketUnitStatDto = new CricketUnitStatDto();

        $cricketUnitStatDto->gameScheduleId = $data['game_id'];
        $cricketUnitStatDto->playerId = $this->getPlayerIdByFeedId($data['profile_id']);
        $cricketUnitStatDto->teamId = $data['team_id'];
        $cricketUnitStatDto->rawStat = $data['stat'];

        return $cricketUnitStatDto;
    }

    private function getPlayerIdByFeedId(string $feedId): int
    {
        return $this->cricketPlayerService->getCricketPlayerByFeedId($feedId)->id;
    }
}
