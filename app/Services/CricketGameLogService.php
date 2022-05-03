<?php

namespace App\Services;

use App\Dto\CricketGameLogDto;
use App\Models\CricketGameLog;
use App\Repositories\CricketGameLogRepository;

class CricketGameLogService
{
    public function __construct(private readonly CricketGameLogRepository $cricketGameLogRepository)
    {
    }

    public function storeCricketGameLog(CricketGameLogDto $cricketGameLogDto): CricketGameLog
    {
        return $this->cricketGameLogRepository->updateOrCreate([
            'game_schedule_id' => $cricketGameLogDto->gameScheduleId,
            'unit_id' => $cricketGameLogDto->unitId,
            'action_point_id' => $cricketGameLogDto->actionPointId,
        ], [
            'value' => $cricketGameLogDto->value,
        ]);
    }
}
