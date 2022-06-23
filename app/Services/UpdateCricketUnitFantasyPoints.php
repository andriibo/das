<?php

namespace App\Services;

use App\Dto\CricketUnitDto;
use App\Helpers\UnitStatsHelper;
use App\Mappers\CricketUnitMapper;
use App\Models\Cricket\CricketUnit;
use App\Models\Cricket\CricketUnitStats;
use App\Repositories\Cricket\CricketUnitStatsRepository;
use App\Services\Cricket\CricketUnitService;
use Illuminate\Support\Collection;

class UpdateCricketUnitFantasyPoints
{
    public function __construct(
        private readonly CricketUnitStatsRepository $cricketUnitStatsRepository,
        private readonly CricketUnitService $cricketUnitService
    ) {
    }

    public function handle(CricketUnit $cricketUnit, array $actionPoints)
    {
        $unitStats = $this->cricketUnitStatsRepository->getRealGameUnitStatsByUnitId($cricketUnit->id);
        $cricketUnitDto = $this->calcFantasyPoints($unitStats, $actionPoints, $cricketUnit);

        $this->cricketUnitService->storeCricketUnit($cricketUnitDto);

        return $cricketUnitDto;
    }

    private function calcFantasyPoints(Collection $unitStats, array $actionPoints, CricketUnit $cricketUnit): CricketUnitDto
    {
        $fantasyPoints = $fantasyPointsPerGame = 0;
        if ($unitStats->isNotEmpty() && $cricketUnit->position) {
            /** @var CricketUnitStats $unitStat */
            foreach ($unitStats as $unitStat) {
                $fantasyPoints += UnitStatsHelper::calcFantasyPointsForStats(
                    $unitStat->stats,
                    $actionPoints,
                    $cricketUnit->position
                );
            }
            $fantasyPointsPerGame = $fantasyPoints / $unitStats->count();
        }

        $cricketUnitMapper = new CricketUnitMapper();

        return $cricketUnitMapper->map([
            'player_id' => $cricketUnit->player_id,
            'team_id' => $cricketUnit->team_id,
            'position' => $cricketUnit->position,
            'fantasy_points' => $fantasyPoints,
            'fantasy_points_per_game' => $fantasyPointsPerGame,
        ]);
    }
}
