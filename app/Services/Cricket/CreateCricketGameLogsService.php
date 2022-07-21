<?php

namespace App\Services\Cricket;

use App\Helpers\UnitStatsHelper;
use App\Mappers\CricketGameLogMapper;
use App\Models\Cricket\CricketUnitStats;
use Illuminate\Support\Facades\Log;

class CreateCricketGameLogsService
{
    public function __construct(private readonly CricketGameLogService $cricketGameLogService)
    {
    }

    public function handle(CricketUnitStats $cricketUnitStats, array $snapshot, array $actionPoints)
    {
        $delta = UnitStatsHelper::delta($cricketUnitStats->stats, $snapshot);
        $this->parseGameLogs($delta, $cricketUnitStats, $actionPoints);
        $reverseDelta = UnitStatsHelper::delta($snapshot, $cricketUnitStats->stats);
        $this->parseGameLogs($reverseDelta, $cricketUnitStats, $actionPoints, true);
    }

    private function parseGameLogs(array $stats, CricketUnitStats $cricketUnitStats, array $actionPoints, $reverse = false): void
    {
        foreach ($stats as $action => $value) {
            if (!$value) {
                continue;
            }
            if ($reverse && $value < 0) {
                continue;
            }
            $foundKey = array_search($action, array_column($actionPoints, 'name'));
            if ($foundKey === false) {
                continue;
            }

            try {
                $actionPointId = $actionPoints[$foundKey]['id'];
                $cricketGameLogMapper = new CricketGameLogMapper();

                $cricketGameLogDto = $cricketGameLogMapper->map([
                    'game_schedule_id' => $cricketUnitStats->game_schedule_id,
                    'unit_id' => $cricketUnitStats->unit_id,
                    'action_point_id' => $actionPointId,
                    'value' => $reverse ? -$value : $value,
                ]);

                $this->cricketGameLogService->storeCricketGameLog($cricketGameLogDto);
            } catch (\Throwable $exception) {
                Log::channel('stderr')->error($exception->getMessage());
            }
        }
    }
}
