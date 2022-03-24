<?php

namespace App\Console\Commands;

use App\Models\CricketGameSchedule;
use App\Services\CricketGameScheduleService;
use App\Services\CricketGoalserveService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitStatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:unit-stat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get unit stats for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(CricketGameScheduleService $cricketGameScheduleService)
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $games = $cricketGameScheduleService->getCricketGameSchedules();
        foreach ($games as $game) {
            $this->parseUnitStats($game);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseUnitStats(CricketGameSchedule $cricketGameSchedule)
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);

        try {
            $formattedDate = $this->getFormattedDate($cricketGameSchedule->game_date);
            $unitStats = $cricketGoalserveService->getGoalserveUnitStats($formattedDate);
            foreach ($unitStats as $unitStat);
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
