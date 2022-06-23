<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Repositories\LeagueRepository;
use App\Services\Cricket\CreateCricketStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketStatsCommand extends Command
{
    protected $signature = 'cricket:stats';

    protected $description = 'Get cricket stats for running contests';

    public function handle(
        LeagueRepository $leagueRepository,
        CreateCricketStatsService $createCricketStatsService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $createCricketStatsService->handle($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
