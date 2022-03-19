<?php

namespace App\Services;

use App\Clients\GoalserveClient;
use App\Enums\LeagueSportIdEnum;
use App\Events\CricketPlayerSavedEvent;
use App\Events\CricketTeamSavedEvent;
use App\Mappers\CricketPlayerMapper;
use App\Mappers\CricketTeamMapper;
use App\Models\CricketPlayer;
use App\Models\CricketTeam;
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
        $leagues = $this->leagueRepository->getListBySportId(LeagueSportIdEnum::cricket);
        foreach ($leagues as $league) {
            if (isset($league->params['league_id'])) {
                $leagueId = $league->params['league_id'];
                $teams = $this->goalserveClient->getCricketTeams($leagueId);
                foreach ($teams as $team) {
                    $cricketTeam = $this->parseTeam($team, $league->id);
                    if ($cricketTeam) {
                        CricketTeamSavedEvent::dispatch($cricketTeam);
                        foreach ($team['player'] as $player) {
                            $playerId = $player['name'];
                            $cricketPlayer = $this->parsePlayer($playerId);
                            if ($cricketPlayer) {
                                CricketPlayerSavedEvent::dispatch($cricketPlayer);
                                $cricketTeam->cricketPlayers()->attach($cricketPlayer->id);
                            }
                        }
                    }
                }
            }
        }
    }

    public function parsePlayers(): void
    {
        $leagues = $this->leagueRepository->getListBySportId(LeagueSportIdEnum::cricket);
        foreach ($leagues as $league) {
            foreach ($league->cricketTeams as $cricketTeam) {
                foreach ($cricketTeam->cricketPlayers as $cricketPlayer) {
                    $cricketPlayer = $this->parsePlayer($cricketPlayer->feed_id);
                    if ($cricketPlayer) {
                        CricketPlayerSavedEvent::dispatch($cricketPlayer);
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
            'feed_type' => $cricketPlayerDto->feedType->name,
            'sport' => $cricketPlayerDto->sport->name,
        ], [
            'first_name' => $cricketPlayerDto->firstName,
            'last_name' => $cricketPlayerDto->lastName,
            'sport_id' => $cricketPlayerDto->sport->name,
            'injury_status' => $cricketPlayerDto->injuryStatus->name,
            'salary' => $cricketPlayerDto->salary,
            'auto_salary' => $cricketPlayerDto->autoSalary,
            'total_fantasy_points' => $cricketPlayerDto->totalFantasyPoints,
            'total_fantasy_points_per_game' => $cricketPlayerDto->totalFantasyPointsPerGame,
        ]);

        if ($cricketPlayer && $data['image']) {
            $storage = $this->cricketPlayerPhotoStorage->storage();
            if ($cricketPlayer->photo && $storage->exists($cricketPlayer->photo)) {
                $storage->delete($cricketPlayer->photo);
            }
            $name = Str::random(40);
            $content = base64_decode($data['image']);
            $photo = $name . 'jpg';
            if ($storage->put($photo, $content)) {
                $cricketPlayer->photo = $photo;
                $cricketPlayer->save();
            }
        }

        return $cricketPlayer;
    }

    private function parseTeam(array $data, int $leagueId): CricketTeam
    {
        $cricketTeamDto = $this->cricketTeamMapper->map($data, $leagueId);

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
