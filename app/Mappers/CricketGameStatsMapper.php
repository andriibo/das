<?php

namespace App\Mappers;

use App\Dto\CricketGameStatsDto;
use App\Services\CricketGameScheduleService;

class CricketGameStatsMapper
{
    public function __construct(private readonly CricketGameScheduleService $cricketGameScheduleService)
    {
    }

    public function map(array $data): CricketGameStatsDto
    {
        $cricketUnitStatsDto = new CricketGameStatsDto();

        $cricketUnitStatsDto->cricketGameScheduleId = $this->getGameScheduleIdByFeedId($data['match']['id']);
        $cricketUnitStatsDto->rawStats = $data;

        return $cricketUnitStatsDto;
    }

    private function getGameScheduleIdByFeedId(string $feedId): int
    {
        return $this->cricketGameScheduleService->getCricketGameScheduleByFeedId($feedId)->id;
    }
}
