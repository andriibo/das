<?php

namespace App\Mappers;

use App\Dto\CricketUnitStatDto;
use App\Services\CricketGameScheduleService;

class CricketUnitStatMapper
{
    public function __construct(private readonly CricketGameScheduleService $cricketGameScheduleService)
    {
    }

    public function map(array $data): CricketUnitStatDto
    {
        $cricketUnitStatDto = new CricketUnitStatDto();

        $cricketUnitStatDto->cricketGameScheduleId = $this->getGameScheduleIdByFeedId($data['maetch']['id']);

        return $cricketUnitStatDto;
    }

    private function getGameScheduleIdByFeedId(string $feedId): int
    {
        return $this->cricketGameScheduleService->getCricketGameScheduleByFeedId($feedId)->id;
    }
}
