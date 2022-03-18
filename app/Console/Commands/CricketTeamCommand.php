<?php

namespace App\Console\Commands;

use App\Events\CricketTeamSavedEvent;
use App\Services\CricketService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class CricketTeamCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:team';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get teams for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CricketService $cricketService)
    {
        Event::listen(function (CricketTeamSavedEvent $event) {
            $this->info("Team: {$event->cricketTeam->name}, Info added!");
        });
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketService->parseTeams();
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
