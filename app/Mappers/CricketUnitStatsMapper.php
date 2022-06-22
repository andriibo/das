<?php

namespace App\Mappers;

use App\Dto\CricketUnitStatsDto;
use App\Enums\CricketUnit\CricketUnitStatActionEnum;
use App\Repositories\Cricket\CricketUnitRepository;

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
        $cricketUnitStatDto->unitId = $data['unit_id'] ?? $this->getUnitId($data['player_id'], $teamId);
        $cricketUnitStatDto->teamId = $teamId;
        $cricketUnitStatDto->stats = $this->mapStats($data['stats']);

        return $cricketUnitStatDto;
    }

    private function getUnitId(int $feedId, int $teamId): int
    {
        return $this->cricketUnitRepository->getByParams($feedId, $teamId)->id;
    }

    private function mapStats(array $stats): array
    {
        $mappedStats = [];
        foreach ($stats as $key => $stat) {
            if (CricketUnitStatActionEnum::tryFrom($key)) {
                $mappedStats[$key] = $stat;
            }
        }

        return $mappedStats;
    }
}
