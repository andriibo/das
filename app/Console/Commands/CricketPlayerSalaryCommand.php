<?php

namespace App\Console\Commands;

use App\Dto\MinAndMaxFantasyPointsDto;
use App\Mappers\CricketPlayerMapper;
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
            $this->updateSalary($minAndMaxFantasyPoints, $player);
        }

        $cricketPlayerService->updatePlayersSalariesWithNoFantasyPoints();
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function updateSalary(MinAndMaxFantasyPointsDto $minAndMaxDto, CricketPlayer $player): void
    {
        /** @var CricketPlayerService $cricketPlayerService */
        $cricketPlayerService = resolve(CricketPlayerService::class);

        $rate = ($player->total_fantasy_points - $minAndMaxDto->min) / ($minAndMaxDto->max - $minAndMaxDto->min);
        $autoSalary = round($rate * (CricketPlayer::MAX_SALARY - CricketPlayer::MIN_SALARY) + CricketPlayer::MIN_SALARY, -2);
        $salary = $player->salary == $player->auto_salary ? $autoSalary : $player->salary;

        $cricketPlayerMapper = new CricketPlayerMapper();
        $cricketPlayerDto = $cricketPlayerMapper->map([
            'id' => $player->feed_id,
            'name' => $player->first_name,
            'photo' => $player->photo,
            'salary' => $salary,
            'auto_salary' => $autoSalary,
        ]);

        $cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
    }
}
