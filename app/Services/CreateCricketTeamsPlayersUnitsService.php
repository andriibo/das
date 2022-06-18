<?php

namespace App\Services;

use App\Mappers\CricketTeamMapper;
use App\Models\League;
use Illuminate\Support\Facades\Log;

class CreateCricketTeamsPlayersUnitsService
{
    public function __construct(
        private readonly CricketTeamService $cricketTeamService,
        private readonly CreateCricketPlayerService $createCricketPlayerService,
        private readonly CreateCricketUnitService $createCricketUnitService
    ) {
    }

    public function handle(League $league): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $leagueId = $league->params['league_id'];
        $teams = $cricketGoalserveService->getGoalserveCricketTeams($leagueId);

        foreach ($teams as $team) {
            try {
                $this->parseCricketTeam($team, $league->id);
            } catch (\Throwable $exception) {
                Log::channel('stderr')->error($exception->getMessage());
            }
        }
    }

    private function parseCricketTeam(array $data, int $leagueId): void
    {
        $cricketTeamMapper = new CricketTeamMapper();
        $cricketTeamDto = $cricketTeamMapper->map($data, $leagueId);
        $cricketTeam = $this->cricketTeamService->storeCricketTeam($cricketTeamDto);

        if (!$cricketTeam) {
            return;
        }
        foreach ($data['player'] as $player) {
            $cricketPlayer = $this->createCricketPlayerService->handle($player);
            $this->createCricketUnitService->handle($cricketPlayer, $cricketTeam->id, $player['role']);
        }
    }
}
