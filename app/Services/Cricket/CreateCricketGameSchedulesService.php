<?php

namespace App\Services\Cricket;

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
            $cricketGameSchedules = $this->cricketGameScheduleService->storeCricketGameSchedules($cricketGameScheduleDto);
            $this->cricketGameScheduleService->confirmGameSchedules($cricketGameSchedules);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
        }
    }
}
