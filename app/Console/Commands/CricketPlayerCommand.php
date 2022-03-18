<?php

namespace App\Console\Commands;

use App\Events\CricketPlayerSavedEvent;
use App\Services\CricketService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class CricketPlayerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:player';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get players for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(CricketService $cricketService)
    {
        Event::listen(function (CricketPlayerSavedEvent $event) {
            $this->info('Player: ' . $event->cricketPlayer->first_name . ', Info added!');
        });
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketService->parsePlayers();
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
