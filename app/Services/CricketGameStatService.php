<?php

namespace App\Services;

use App\Dto\CricketGameStatDto;
use App\Models\CricketGameStat;
use App\Repositories\CricketGameStatRepository;
use Illuminate\Database\Eloquent\Collection;

class CricketGameStatService
{
    public function __construct(
        private readonly CricketGameStatRepository $cricketGameStatRepository
    ) {
    }

    /**
     * @return Collection|CricketGameStat[]
     */
    public function getCricketGameStats(): Collection
    {
        return $this->cricketGameStatRepository->getList();
    }

    public function storeCricketGameStat(CricketGameStatDto $cricketGameStatDto): CricketGameStat
    {
        return $this->cricketGameStatRepository->updateOrCreate([
            'cricket_game_schedule_id' => $cricketGameStatDto->cricketGameScheduleId,
        ], [
            'raw_stat' => $cricketGameStatDto->rawStat,
        ]);
    }
}
