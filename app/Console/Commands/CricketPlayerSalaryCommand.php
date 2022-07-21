<?php

namespace App\Console\Commands;

use App\Services\Cricket\CricketPlayerService;
use App\Services\Cricket\UpdateCricketPlayerSalaryService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketPlayerSalaryCommand extends Command
{
    protected $signature = 'cricket:player-salary';

    protected $description = 'Calculate cricket players salaries';

    public function handle(
        CricketPlayerService $cricketPlayerService,
        UpdateCricketPlayerSalaryService $updateCricketPlayerSalaryService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $minAndMaxFantasyPoints = $cricketPlayerService->getMinAndMaxFantasyPoints();
        $playersWithCalculatedFantasyPoints = $cricketPlayerService->getPlayersWithCalculatedFantasyPoints();
        foreach ($playersWithCalculatedFantasyPoints as $player) {
            $updateCricketPlayerSalaryService->handle($minAndMaxFantasyPoints, $player);
        }
        $cricketPlayerService->updatePlayersSalariesWithNoFantasyPoints();
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
