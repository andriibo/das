<?php

namespace App\Services\Cricket;

use App\Mappers\CricketGameStatsMapper;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Support\Facades\Log;

class CreateCricketGameStatsService
{
    public function __construct(
        private readonly CricketGoalserveService $cricketGoalserveService,
        private readonly CricketGameStatsMapper $cricketGameStatsMapper,
        private readonly CricketGameStatsService $cricketGameStatsService,
        private readonly CreateCricketUnitStatsService $createCricketUnitStatsService
    ) {
    }

    public function handle(CricketGameSchedule $cricketGameSchedule)
    {
        try {
            $leagueFeedId = $cricketGameSchedule->league->params['league_id'];
            $formattedDate = $this->getFormattedDate($cricketGameSchedule->game_date);
            $data = $this->cricketGoalserveService->getGoalserveGameStats($formattedDate, $leagueFeedId, $cricketGameSchedule->feed_id);
            if (empty($data)) {
                Log::channel('stderr')->error("No data for date {$formattedDate} and feed_id {$cricketGameSchedule->feed_id}");

                return;
            }

            $cricketGameStatsDto = $this->cricketGameStatsMapper->map($data);
            $cricketGameStats = $this->cricketGameStatsService->storeCricketGameStats($cricketGameStatsDto);
            $this->createCricketUnitStatsService->handle($cricketGameStats);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
        }
    }

    private function getFormattedDate(string $dateTime): string
    {
        $dateTime = new \DateTime($dateTime);

        return $dateTime->format('d.m.Y');
    }
}
