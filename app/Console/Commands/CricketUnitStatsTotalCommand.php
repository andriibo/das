<?php

namespace App\Console\Commands;

use App\Helpers\ArrayHelper;
use App\Mappers\CricketUnitStatsMapper;
use App\Models\CricketUnit;
use App\Repositories\CricketUnitRepository;
use App\Services\CricketUnitStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitStatsTotalCommand extends Command
{
    protected $signature = 'cricket:unit-stats-total';

    protected $description = 'Calculate total cricket unit stats';

    public function handle(CricketUnitRepository $cricketUnitRepository): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketUnits = $cricketUnitRepository->getList();

        /** @var CricketUnit $cricketUnit */
        foreach ($cricketUnits as $cricketUnit) {
            $statsTotal = $this->calcCricketUnitTotalStats($cricketUnit);
            $this->saveTotalUnitStats($cricketUnit, $statsTotal);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function calcCricketUnitTotalStats(CricketUnit $cricketUnit): array
    {
        $stats = [];
        foreach ($cricketUnit->unitStats as $unitStat) {
            $stats = ArrayHelper::sum($stats, $unitStat->stats);
        }

        return $stats;
    }

    private function saveTotalUnitStats(CricketUnit $cricketUnit, array $statsTotal): void
    {
        /* @var $cricketUnitStatsService CricketUnitStatsService
        * @var $cricketUnitStatsMapper CricketUnitStatsMapper */
        $cricketUnitStatsService = resolve(CricketUnitStatsService::class);
        $cricketUnitStatsMapper = resolve(CricketUnitStatsMapper::class);
        $cricketUnitStatsDto = $cricketUnitStatsMapper->map([
            'game_id' => null,
            'unit_id' => $cricketUnit->id,
            'player_id' => $cricketUnit->player_id,
            'team_id' => $cricketUnit->team_id,
            'stats' => $statsTotal,
        ]);
        $cricketUnitStatsService->storeCricketUnitStats($cricketUnitStatsDto);
    }
}
