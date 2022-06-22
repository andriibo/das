<?php

namespace App\Repositories\Cricket;

use App\Dto\CricketPlayerDto;
use App\Dto\MinAndMaxFantasyPointsDto;
use App\Models\Cricket\CricketPlayer;
use Illuminate\Support\Collection;

class CricketPlayerRepository
{
    /**
     * @return Collection|CricketPlayer[]
     */
    public function getList(): Collection
    {
        return CricketPlayer::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketPlayer
    {
        return CricketPlayer::updateOrCreate($attributes, $values);
    }

    public function updateFantasyPoints(CricketPlayer $cricketPlayer, CricketPlayerDto $cricketPlayerDto): bool
    {
        return $cricketPlayer->update(
            [
                'total_fantasy_points' => $cricketPlayerDto->totalFantasyPoints,
                'total_fantasy_points_per_game' => $cricketPlayerDto->totalFantasyPointsPerGame,
            ]
        );
    }

    public function getMinAndMaxFantasyPoints(): MinAndMaxFantasyPointsDto
    {
        $minAndMax = new MinAndMaxFantasyPointsDto();
        $minAndMax->min = CricketPlayer::query()->min('total_fantasy_points');
        $minAndMax->max = CricketPlayer::query()->max('total_fantasy_points');

        return $minAndMax;
    }

    /**
     * @return Collection|CricketPlayer[]
     */
    public function getPlayersWithCalculatedFantasyPoints(): Collection
    {
        return CricketPlayer::query()->whereNotNull('total_fantasy_points')->get();
    }

    public function updateSalaryIfNoFantasyPointsAndSalariesMatch(): void
    {
        CricketPlayer::query()
            ->whereRaw('total_fantasy_points IS NULL AND salary <=> auto_salary')
            ->update(['salary' => CricketPlayer::NO_DATA_SALARY])
        ;
    }

    public function updateAutoSalaryIfNoFantasyPoints(): void
    {
        CricketPlayer::query()
            ->whereNull('total_fantasy_points')
            ->update(['salary' => CricketPlayer::NO_DATA_SALARY])
        ;
    }
}
