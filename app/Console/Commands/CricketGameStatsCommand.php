<?php

namespace App\Console\Commands;

use App\Mappers\CricketGameStatsMapper;
use App\Models\CricketGameSchedule;
use App\Services\CricketGameScheduleService;
use App\Services\CricketGameStatsService;
use App\Services\CricketGoalserveService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketGameStatsCommand extends Command
{
    protected $signature = 'cricket:game-stats';

    protected $description = 'Get game stats for sport Cricket from Goalserve';

    public function handle(CricketGameScheduleService $cricketGameScheduleService): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $games = $cricketGameScheduleService->getCricketGameSchedules();
        foreach ($games as $game) {
            $this->parseGameStats($game);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseGameStats(CricketGameSchedule $cricketGameSchedule): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService */
        /* @var $cricketGameStatsMapper CricketGameStatsMapper */
        /* @var $cricketGameStatsService CricketGameStatsService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $cricketGameStatsService = resolve(CricketGameStatsService::class);
        $cricketGameStatsMapper = resolve(CricketGameStatsMapper::class);

        try {
            $formattedDate = $this->getFormattedDate($cricketGameSchedule->game_date);
            $data = $cricketGoalserveService->getGoalserveGameStats($formattedDate, $cricketGameSchedule->feed_id);

            if (empty($data)) {
                $this->error("No data for date {$formattedDate} and feed_id {$cricketGameSchedule->feed_id}");

                return;
            }

            $cricketGameStatsDto = $cricketGameStatsMapper->map($data);
            $cricketGameStatsService->storeCricketGameStats($cricketGameStatsDto);
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function getFormattedDate(string $dateTime): string
    {
        $dateTime = new \DateTime($dateTime);

        return $dateTime->format('d.m.Y');
    }
}
