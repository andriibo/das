<?php

namespace App\Services;

use App\Clients\GoalserveClient;
use App\Enums\LeagueSportIdEnum;
use App\Events\CricketPlayerSavedEvent;
use App\Mappers\CricketPlayerMapper;
use App\Mappers\CricketTeamMapper;
use App\Models\CricketPlayer;
use App\Repositories\CricketPlayerRepository;
use App\Repositories\CricketTeamRepository;
use App\Repositories\LeagueRepository;
use App\Storages\CricketPlayerPhotoStorage;
use Illuminate\Support\Str;

class CricketService
{
    public function __construct(
        private readonly GoalserveClient $goalserveClient,
        private readonly LeagueRepository $leagueRepository,
        private readonly CricketTeamRepository $cricketTeamRepository,
        private readonly CricketPlayerRepository $cricketPlayerRepository,
        private readonly CricketTeamMapper $cricketTeamMapper,
        private readonly CricketPlayerMapper $cricketPlayerMapper,
        private readonly CricketPlayerPhotoStorage $cricketPlayerPhotoStorage
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
                        $cricketPlayer = $this->parsePlayer($playerId);
                        if ($cricketPlayer) {
                            CricketPlayerSavedEvent::dispatch($cricketPlayer);
                        }
                    }
                }
            }
        }
    }

    public function parsePlayer(int $playerId): ?CricketPlayer
    {
        $data = $this->goalserveClient->getCricketPlayer($playerId);
        if (is_null($data)) {
            return null;
        }
        $cricketPlayerDto = $this->cricketPlayerMapper->map($data);
        $cricketPlayer = $this->cricketPlayerRepository->updateOrCreate([
            'feed_id' => $cricketPlayerDto->feedId,
            'first_name' => $cricketPlayerDto->firstName,
        ], [
            'last_name' => $cricketPlayerDto->lastName,
            'sport_id' => $cricketPlayerDto->sportId->value,
            'injury_status' => $cricketPlayerDto->injuryStatus->name,
            'salary' => $cricketPlayerDto->salary,
            'auto_salary' => $cricketPlayerDto->autoSalary,
            'total_fantasy_points' => $cricketPlayerDto->totalFantasyPoints,
            'total_fantasy_points_per_game' => $cricketPlayerDto->totalFantasyPointsPerGame,
        ]);

        if ($cricketPlayer && $data['image']) {
            $storage = $this->cricketPlayerPhotoStorage->storage();
            if ($cricketPlayer->image_name && $storage->exists($cricketPlayer->image_name)) {
                $storage->delete($cricketPlayer->image_name);
            }
            $name = Str::random(40);
            $content = base64_decode($data['image']);
            $imageName = $name . 'jpg';
            if ($storage->put($imageName, $content)) {
                $cricketPlayer->image_name = $imageName;
                $cricketPlayer->save();
            }
        }

        return $cricketPlayer;
    }
}
