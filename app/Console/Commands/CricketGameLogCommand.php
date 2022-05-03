<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Mappers\CricketGameLogMapper;
use App\Models\CricketUnitStats;
use App\Repositories\CricketUnitRepository;
use App\Services\ActionPointService;
use App\Services\CricketGameLogService;
use App\Services\CricketUnitStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketGameLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:game-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get game log from unit stats';

    /**
     * Execute the console command.
     */
    public function handle(CricketUnitStatsService $cricketUnitStatsService, ActionPointService $actionPointService): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $items = $cricketUnitStatsService->getCricketUnitStats();
        $actionPoints = $actionPointService->getListBySportId(SportIdEnum::cricket)->toArray();
        foreach ($items as $item) {
            $this->handleUnitStats($item, $actionPoints);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function handleUnitStats(CricketUnitStats $cricketUnitStats, array $actionPoints): void
    {
        $cricketUnitRepository = new CricketUnitRepository();
        foreach ($cricketUnitStats->raw_stats as $key => $value) {
            if ($value === '') {
                continue;
            }
            $foundKey = array_search($key, array_column($actionPoints, 'name'));
            if ($foundKey === false) {
                continue;
            }

            try {
                $cricketUnit = $cricketUnitRepository->getByParams($cricketUnitStats->team_id, $cricketUnitStats->player_id);
                $actionPointId = $actionPoints[$foundKey]['id'];
                $this->parseGameLog($cricketUnitStats->game_schedule_id, $cricketUnit->id, $actionPointId, $value);
            } catch (\Throwable $exception) {
                $this->error($exception->getMessage());
            }
        }
    }

    private function parseGameLog(int $gameScheduleId, int $unitId, int $actionPointId, float $value): void
    {
        /* @var $cricketGameLogService CricketGameLogService */
        $cricketGameLogService = resolve(CricketGameLogService::class);
        $cricketGameLogMapper = new CricketGameLogMapper();

        $cricketGameLogDto = $cricketGameLogMapper->map([
            'game_schedule_id' => $gameScheduleId,
            'unit_id' => $unitId,
            'action_point_id' => $actionPointId,
            'value' => $value,
        ]);

        $cricketGameLogService->storeCricketGameLog($cricketGameLogDto);
    }
}
