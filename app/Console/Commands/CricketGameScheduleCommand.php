<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Mappers\CricketGameScheduleMapper;
use App\Models\League;
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
    public function handle(LeagueService $leagueService)
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueService->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $this->parseMatches($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseMatches(League $league): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);

        try {
            $leagueId = $league->params['league_id'];
            $matches = $cricketGoalserveService->getGoalserveCricketMatches($leagueId);
            foreach ($matches as $match) {
                $this->parseMatch($match, $league->id);
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function parseMatch(array $data, int $leagueId): void
    {
        /* @var $cricketGameScheduleService CricketGameScheduleService
        * @var $cricketGameScheduleMapper CricketGameScheduleMapper */
        $cricketGameScheduleService = resolve(CricketGameScheduleService::class);
        $cricketGameScheduleMapper = resolve(CricketGameScheduleMapper::class);

        try {
            $cricketGameScheduleDto = $cricketGameScheduleMapper->map($data, $leagueId);
            $cricketGameSchedule = $cricketGameScheduleService->storeCricketGameSchedule($cricketGameScheduleDto);
            $cricketGameScheduleService->updateDataConfirmed($cricketGameSchedule);
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }
}
