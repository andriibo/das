<?php

namespace App\Mappers;

use App\Dto\CricketGameStatDto;
use App\Services\CricketGameScheduleService;

class CricketGameStatMapper
{
    public function __construct(private readonly CricketGameScheduleService $cricketGameScheduleService)
    {
    }

    public function map(array $data): CricketGameStatDto
    {
        $cricketUnitStatDto = new CricketGameStatDto();

        $cricketUnitStatDto->cricketGameScheduleId = $this->getGameScheduleIdByFeedId($data['match']['id']);
        $cricketUnitStatDto->rawStat = $data;

        return $cricketUnitStatDto;
    }

    private function getGameScheduleIdByFeedId(string $feedId): int
    {
        return $this->cricketGameScheduleService->getCricketGameScheduleByFeedId($feedId)->id;
    }
}
