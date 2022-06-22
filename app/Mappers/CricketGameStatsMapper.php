<?php

namespace App\Mappers;

use App\Dto\CricketGameStatsDto;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class CricketGameStatsMapper
{
    public function __construct(private readonly CricketGameScheduleRepository $cricketGameScheduleRepository)
    {
    }

    public function map(array $data): CricketGameStatsDto
    {
        $cricketUnitStatsDto = new CricketGameStatsDto();

        $cricketUnitStatsDto->gameScheduleId = $this->getGameScheduleIdByFeedId($data['match']['id']);
        $cricketUnitStatsDto->rawStats = $data;

        return $cricketUnitStatsDto;
    }

    private function getGameScheduleIdByFeedId(string $feedId): int
    {
        return $this->cricketGameScheduleRepository->getByFeedId($feedId)->id;
    }
}
