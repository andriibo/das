<?php

namespace App\Console\Commands;

use App\Dto\CricketPlayerDto;
use App\Dto\MinAndMaxFantasyPointsDto;
use App\Models\CricketPlayer;
use App\Services\CricketPlayerService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketPlayerSalaryCommand extends Command
{
    protected $signature = 'cricket:player-salary';

    protected $description = 'Calculate cricket players salaries';

    public function handle(CricketPlayerService $cricketPlayerService): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $minAndMaxFantasyPoints = $cricketPlayerService->getMinAndMaxFantasyPoints();
        $playersWithCalculatedFantasyPoints = $cricketPlayerService->getPlayersWithCalculatedFantasyPoints();

        foreach ($playersWithCalculatedFantasyPoints as $player) {
            $this->updateSalaries($minAndMaxFantasyPoints, $player);
        }
        $cricketPlayerService->updatePlayersSalariesWithNoFantasyPoints();
    }

    private function updateSalaries(MinAndMaxFantasyPointsDto $MinAndMaxDto, CricketPlayer $player): void
    {
        $playerService = resolve(CricketPlayerService::class);

        $rate = ($player->total_fantasy_points - $MinAndMaxDto->min) / ($MinAndMaxDto->max - $MinAndMaxDto->min);
        $autoSalary = round($rate * (CricketPlayer::MAX_SALARY - CricketPlayer::MIN_SALARY) + CricketPlayer::MIN_SALARY, -2);

        $playerDto = new CricketPlayerDto();

        if ($player->salary == $player->auto_salary) {
            $playerDto->salary = $autoSalary;
        } else {
            $playerDto->salary = $player->salary;
        }
        $playerDto->autoSalary = $autoSalary;

        $playerService->updatePlayerSalaries($playerDto, $player);
    }
}
