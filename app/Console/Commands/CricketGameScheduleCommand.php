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
        LeagueService $leagueService,
    ) {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueService->getListBySportId(LeagueSportIdEnum::cricket);
        foreach ($leagues as $league) {
            try {
                $leagueId = $league->params['league_id'];
                $matches = $cricketGoalserveService->getGoalserveMatches($leagueId);
                foreach ($matches as $match) {
                    $this->parseMatch($match, $league->id);
                }
            } catch (\Throwable $exception) {
                $this->error($exception->getMessage());
            }
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseMatch(array $data, int $leagueId): void
    {
        $cricketGameScheduleService = resolve(CricketGameScheduleService::class);
        $cricketGameScheduleMapper = resolve(CricketGameScheduleMapper::class);

        try {
            $cricketGameScheduleDto = $cricketGameScheduleMapper->map($data, $leagueId);
            $cricketGameScheduleService->storeCricketGameSchedule($cricketGameScheduleDto);
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }
}
