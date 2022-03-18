<?php

namespace App\Services;

use App\Clients\GoalserveClient;
use App\Enums\LeagueSportIdEnum;
use App\Mappers\CricketTeamMapper;
use App\Repositories\CricketTeamRepository;
use App\Repositories\LeagueRepository;

class CricketService
{
    public function __construct(
        private readonly GoalserveClient $goalserveClient,
        private readonly LeagueRepository $leagueRepository,
        private readonly CricketTeamRepository $cricketTeamRepository,
        private readonly CricketTeamMapper $cricketTeamMapper
    ) {
    }

    public function parseTeams(): void
    {
        $leagues = $this->leagueRepository->getListBySportId(LeagueSportIdEnum::Cricket);
        foreach ($leagues as $league) {
            if (isset($league->params['league_id'])) {
                $leagueId = $league->params['league_id'];
                $teams = $this->goalserveClient->getCricketTeams($leagueId);
                foreach ($teams as $team) {
                    $this->parseTeam($team, $leagueId);
                }
            }
        }
    }

    private function parseTeam(array $data, int $leagueId): void
    {
        $cricketTeamDto = $this->cricketTeamMapper->map($data, $leagueId);
        $cricketTeam = $this->cricketTeamRepository->updateOrCreate([
            'feed_id' => $cricketTeamDto->feedId,
            'league_id' => $cricketTeamDto->leagueId,
            'name' => $cricketTeamDto->name,
        ], [
            'nickname' => $cricketTeamDto->nickname,
            'alias' => $cricketTeamDto->alias,
            'country_id' => $cricketTeamDto->countryId,
            'logo_id' => $cricketTeamDto->logoId,
            'feed_type' => $cricketTeamDto->feedType->name,
        ]);
        echo 'Team: ' . $cricketTeam->name . ', Info added!' . PHP_EOL;
    }
}
