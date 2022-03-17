<?php

namespace App\Services;

use App\Clients\GoalserveClient;
use App\Enums\LeagueSportIdEnum;
use App\Mappers\CricketPlayerMapper;
use App\Mappers\CricketTeamMapper;
use App\Repositories\CricketPlayerRepository;
use App\Repositories\CricketTeamRepository;
use App\Repositories\LeagueRepository;

class CricketService
{
    public function __construct(
        private readonly GoalserveClient $goalserveClient,
        private readonly LeagueRepository $leagueRepository,
        private readonly CricketTeamRepository $cricketTeamRepository,
        private readonly CricketPlayerRepository $cricketPlayerRepository,
        private readonly CricketTeamMapper $cricketTeamMapper,
        private readonly CricketPlayerMapper $cricketPlayerMapper
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
                    $cricketTeamDto = $this->cricketTeamMapper->map($team, $leagueId);
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
        }
    }

    public function parsePlayers(): void
    {
        $leagues = $this->leagueRepository->getListBySportId(LeagueSportIdEnum::Cricket);
        foreach ($leagues as $league) {
            if (isset($league->params['league_id'])) {
                $leagueId = $league->params['league_id'];
                $teams = $this->goalserveClient->getCricketTeams($leagueId);
                foreach ($teams as $team) {
                    foreach ($team['player'] as $player) {
                        $playerId = $player['name'];
                        $data = $this->goalserveClient->getCricketPlayer($playerId);
                        if (is_null($data)) {
                            echo "Player: Couldn't add info for player with ID {$playerId}" . PHP_EOL;

                            continue;
                        }
                        $cricketPlayerDto = $this->cricketPlayerMapper->map($data);
                        $cricketPlayer = $this->cricketPlayerRepository->updateOrCreate([
                            'feed_id' => $cricketPlayerDto->feedId,
                            'first_name' => $cricketPlayerDto->firstName,
                        ], [
                            'last_name' => $cricketPlayerDto->lastName,
                            'sport_id' => $cricketPlayerDto->sportId->value,
                            'photo_id' => $cricketPlayerDto->photoId,
                            'injury_status' => $cricketPlayerDto->injuryStatus->name,
                            'salary' => $cricketPlayerDto->salary,
                            'auto_salary' => $cricketPlayerDto->autoSalary,
                            'total_fantasy_points' => $cricketPlayerDto->totalFantasyPoints,
                            'total_fantasy_points_per_game' => $cricketPlayerDto->totalFantasyPointsPerGame,
                        ]);
                        echo 'Player: ' . $cricketPlayer->first_name . ', Info added!' . PHP_EOL;
                    }
                }
            }
        }
    }
}
