<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Repositories\LeagueRepository;
use App\Services\Cricket\CreateCricketGameStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketGameStatsCommand extends Command
{
    protected $signature = 'cricket:game-stats';

    protected $description = 'Get cricket game stats for running contests';

    public function handle(
        LeagueRepository $leagueRepository,
        CreateCricketGameStatsService $createCricketGameStatsService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $createCricketGameStatsService->handle($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
