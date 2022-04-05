<?php

namespace App\Console\Commands;

use App\Mappers\CricketGameStatMapper;
use App\Models\CricketGameSchedule;
use App\Services\CricketGameScheduleService;
use App\Services\CricketGameStatService;
use App\Services\CricketGoalserveService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketGameStatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:game-stat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get game stats for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
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
        /* @var $cricketGameStatMapper CricketGameStatMapper */
        /* @var $cricketGameStatService CricketGameStatService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $cricketGameStatService = resolve(CricketGameStatService::class);
        $cricketGameStatMapper = resolve(CricketGameStatMapper::class);

        try {
            $formattedDate = $this->getFormattedDate($cricketGameSchedule->game_date);
            $data = $cricketGoalserveService->getGoalserveGameStat($formattedDate, $cricketGameSchedule->feed_id);

            if (empty($data)) {
                $this->error("No data for date {$formattedDate} and feed_id {$cricketGameSchedule->feed_id}");

                return;
            }

            $cricketGameStatDto = $cricketGameStatMapper->map($data);
            $cricketGameStatService->storeCricketGameStat($cricketGameStatDto);
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
