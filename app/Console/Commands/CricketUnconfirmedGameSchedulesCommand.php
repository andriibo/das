<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Repositories\LeagueRepository;
use App\Services\Cricket\UnconfirmedGameSchedulesService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnconfirmedGameSchedulesCommand extends Command
{
    protected $signature = 'cricket:unconfirmed-game-schedules';

    protected $description = 'Get cricket stats for unconfirmed game schedules';

    public function handle(
        LeagueRepository $leagueRepository,
        UnconfirmedGameSchedulesService $unconfirmedGameSchedulesService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $unconfirmedGameSchedulesService->handle($league->id);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
