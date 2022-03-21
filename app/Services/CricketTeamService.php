<?php

namespace App\Services;

use App\Dto\CricketTeamDto;
use App\Models\CricketTeam;
use App\Repositories\CricketTeamRepository;
use Illuminate\Support\Collection;

class CricketTeamService
{
    public function __construct(
        private readonly CricketTeamRepository $cricketTeamRepository
    ) {
    }

    /**
     * @return Collection|CricketTeam[]
     */
    public function getCricketTeams(): Collection
    {
        return $this->cricketTeamRepository->getList();
    }

    public function storeCricketTeam(CricketTeamDto $cricketTeamDto): CricketTeam
    {
        return $this->cricketTeamRepository->updateOrCreate([
            'feed_id' => $cricketTeamDto->feedId,
            'league_id' => $cricketTeamDto->leagueId,
            'feed_type' => $cricketTeamDto->feedType->name,
        ], [
            'name' => $cricketTeamDto->name,
            'nickname' => $cricketTeamDto->nickname,
            'alias' => $cricketTeamDto->alias,
            'country_id' => $cricketTeamDto->countryId,
            'logo' => $cricketTeamDto->logo,
        ]);
    }
}
