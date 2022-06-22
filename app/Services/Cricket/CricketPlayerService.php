<?php

namespace App\Services\Cricket;

use App\Dto\CricketPlayerDto;
use App\Dto\MinAndMaxFantasyPointsDto;
use App\Models\Cricket\CricketPlayer;
use App\Repositories\Cricket\CricketPlayerRepository;
use Illuminate\Database\Eloquent\Collection;

class CricketPlayerService
{
    public function __construct(
        private readonly CricketPlayerRepository $cricketPlayerRepository
    ) {
    }

    public function storeCricketPlayer(CricketPlayerDto $cricketPlayerDto): CricketPlayer
    {
        return $this->cricketPlayerRepository->updateOrCreate([
            'feed_id' => $cricketPlayerDto->feedId,
            'feed_type' => $cricketPlayerDto->feedType->name,
        ], [
            'first_name' => $cricketPlayerDto->firstName,
            'last_name' => $cricketPlayerDto->lastName,
            'injury_status' => $cricketPlayerDto->injuryStatus->name,
            'salary' => $cricketPlayerDto->salary,
            'auto_salary' => $cricketPlayerDto->autoSalary,
        ]);
    }

    public function updateFantasyPoints(cricketPlayer $cricketPlayer, CricketPlayerDto $cricketPlayerDto): void
    {
        $this->cricketPlayerRepository->updateFantasyPoints($cricketPlayer, $cricketPlayerDto);
    }

    public function getMinAndMaxFantasyPoints(): MinAndMaxFantasyPointsDto
    {
        return $this->cricketPlayerRepository->getMinAndMaxFantasyPoints();
    }

    public function getPlayersWithCalculatedFantasyPoints(): Collection
    {
        return $this->cricketPlayerRepository->getPlayersWithCalculatedFantasyPoints();
    }

    public function updatePlayersSalariesWithNoFantasyPoints(): void
    {
        $this->cricketPlayerRepository->updateSalaryIfNoFantasyPointsAndSalariesMatch();
        $this->cricketPlayerRepository->updateAutoSalaryIfNoFantasyPoints();
    }
}
