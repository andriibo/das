<?php

namespace App\Services\Cricket;

use App\Mappers\CricketGameLogMapper;
use App\Models\Cricket\CricketUnitStats;
use Illuminate\Support\Facades\Log;

class CreateCricketGameLogsService
{
    public function __construct(private readonly CricketGameLogService $cricketGameLogService)
    {
    }

    public function handle(CricketUnitStats $cricketUnitStats, array $actionPoints)
    {
        foreach ($cricketUnitStats->stats as $key => $value) {
            if (!$value) {
                continue;
            }
            $foundKey = array_search($key, array_column($actionPoints, 'name'));
            if ($foundKey === false) {
                continue;
            }

            try {
                $actionPointId = $actionPoints[$foundKey]['id'];
                $this->parseGameLog($cricketUnitStats->game_schedule_id, $cricketUnitStats->unit_id, $actionPointId, $value);
            } catch (\Throwable $exception) {
                Log::channel('stderr')->error($exception->getMessage());
            }
        }
    }

    private function parseGameLog(int $gameScheduleId, int $unitId, int $actionPointId, float $value): void
    {
        $cricketGameLogMapper = new CricketGameLogMapper();

        $cricketGameLogDto = $cricketGameLogMapper->map([
            'game_schedule_id' => $gameScheduleId,
            'unit_id' => $unitId,
            'action_point_id' => $actionPointId,
            'value' => $value,
        ]);

        $this->cricketGameLogService->storeCricketGameLog($cricketGameLogDto);
    }
}
