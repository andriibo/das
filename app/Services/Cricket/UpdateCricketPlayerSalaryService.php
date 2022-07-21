<?php

namespace App\Services\Cricket;

use App\Dto\MinAndMaxFantasyPointsDto;
use App\Mappers\CricketPlayerMapper;
use App\Models\Cricket\CricketPlayer;

class UpdateCricketPlayerSalaryService
{
    public function __construct(private readonly CricketPlayerService $cricketPlayerService)
    {
    }

    public function handle(MinAndMaxFantasyPointsDto $minAndMaxDto, CricketPlayer $player): void
    {
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

        $this->cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
    }
}
