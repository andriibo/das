<?php

namespace App\Services\Cricket;

use App\Dto\CricketTeamDto;
use App\Models\Cricket\CricketTeam;
use App\Repositories\Cricket\CricketTeamRepository;

class CreateCricketTeamService
{
    public function __construct(
        private readonly CricketTeamRepository $cricketTeamRepository
    ) {
    }

    public function handle(CricketTeamDto $cricketTeamDto): CricketTeam
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
