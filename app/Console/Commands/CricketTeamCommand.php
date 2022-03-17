<?php

namespace App\Console\Commands;

use App\Services\CricketService;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketService->parseTeams();
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
