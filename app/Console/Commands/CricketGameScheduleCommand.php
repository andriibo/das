<?php

namespace App\Console\Commands;

use App\Enums\LeagueSportIdEnum;
use App\Mappers\CricketGameScheduleMapper;
use App\Services\CricketGameScheduleService;
use App\Services\CricketGoalserveService;
use App\Services\LeagueService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketGameScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:game-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get matches for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(
        CricketGoalserveService $cricketGoalserveService,
        CricketGameScheduleService $cricketGameScheduleService,
        LeagueService $leagueService,
        CricketGameScheduleMapper $cricketGameScheduleMapper,
    ) {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueService->getListBySportId(LeagueSportIdEnum::cricket);
        foreach ($leagues as $league) {
            if (isset($league->params['league_id'])) {
                $leagueId = $league->params['league_id'];

                try {
                    $matches = $cricketGoalserveService->getGoalserveMatches($leagueId);
                    foreach ($matches as $match) {
                        $cricketGameScheduleDto = $cricketGameScheduleMapper->map($match, $league->id);
                        $cricketGameSchedule = $cricketGameScheduleService->storeCricketGameSchedule($cricketGameScheduleDto);
                        if ($cricketGameSchedule) {
                            $this->info("Game Schedule: {$cricketGameSchedule->game_date}, Info added!");
                        }
                    }
                } catch (\Throwable $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
