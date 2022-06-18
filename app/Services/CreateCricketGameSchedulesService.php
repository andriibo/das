<?php

namespace App\Services;

use App\Mappers\CricketGameScheduleMapper;
use App\Models\League;
use Illuminate\Support\Facades\Log;

class CreateCricketGameSchedulesService
{
    public function __construct(
        private readonly CricketGoalserveService $cricketGoalserveService,
        private readonly CricketGameScheduleService $cricketGameScheduleService,
        private readonly CricketGameScheduleMapper $cricketGameScheduleMapper
    ) {
    }

    public function handle(League $league): void
    {
        try {
            $leagueId = $league->params['league_id'];
            $matches = $this->cricketGoalserveService->getGoalserveCricketMatches($leagueId);
            foreach ($matches as $match) {
                $this->parseMatch($match, $league->id);
            }
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
        }
    }

    private function parseMatch(array $data, int $leagueId): void
    {
        try {
            $cricketGameScheduleDto = $this->cricketGameScheduleMapper->map($data, $leagueId);
            $cricketGameSchedule = $this->cricketGameScheduleService->storeCricketGameSchedule($cricketGameScheduleDto);
            $this->cricketGameScheduleService->updateDataConfirmed($cricketGameSchedule);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
        }
    }
}
