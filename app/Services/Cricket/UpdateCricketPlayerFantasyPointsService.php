<?php

namespace App\Services\Cricket;

use App\Dto\CricketPlayerDto;
use App\Models\Cricket\CricketPlayer;
use App\Repositories\Cricket\CricketUnitStatsRepository;

class UpdateCricketPlayerFantasyPointsService
{
    public function __construct(
        private readonly UpdateCricketUnitFantasyPoints $updateCricketUnitFantasyPoints,
        private readonly CricketUnitStatsRepository $cricketUnitStatsRepository,
        private readonly StoreCricketPlayerService $cricketPlayerService
    ) {
    }

    public function handle(CricketPlayer $cricketPlayer, array $actionPoints): void
    {
        $playerDto = new CricketPlayerDto();
        $playerDto->totalFantasyPoints = 0;
        $playerDto->totalFantasyPointsPerGame = 0;
        if ($cricketPlayer->cricketUnits) {
            $gamesCount = 0;
            foreach ($cricketPlayer->cricketUnits as $cricketUnit) {
                $cricketUnitDto = $this->updateCricketUnitFantasyPoints->handle($cricketUnit, $actionPoints);
                $playerDto->totalFantasyPoints += $cricketUnitDto->fantasyPoints;
                $gamesCount += $this->cricketUnitStatsRepository->getRealGameUnitStatsByUnitId($cricketUnit->id)->count();
            }
            if ($gamesCount > 0) {
                $playerDto->totalFantasyPointsPerGame = $playerDto->totalFantasyPoints / $gamesCount;
            }

            $this->cricketPlayerService->updateFantasyPoints($cricketPlayer, $playerDto);
        }
    }
}
