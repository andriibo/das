<?php

namespace App\Services\Cricket;

use App\Mappers\CricketTeamMapper;
use App\Mappers\CricketUnitMapper;
use App\Models\League;
use Illuminate\Support\Facades\Log;

class CreateCricketTeamsPlayersUnitsService
{
    public function __construct(
        private readonly CricketTeamService $cricketTeamService,
        private readonly CreateCricketPlayerService $createCricketPlayerService,
        private readonly CricketUnitMapper $cricketUnitMapper,
        private readonly CreateCricketUnitService $createCricketUnitService,
        private readonly UpdateCricketUnitStatusService $updateCricketUnitStatusService
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
        $existCricketUnitIds = [];

        if (!$cricketTeam) {
            return;
        }
        foreach ($data['player'] as $player) {
            try {
                $cricketPlayer = $this->createCricketPlayerService->handle($player);
                $position = $player['role'];

                if (!$position) {
                    Log::channel('stderr')->info("Role for player id {$player['name']} does not exist.");

                    continue;
                }

                $cricketUnitDto = $this->cricketUnitMapper->map([
                    'player_id' => $cricketPlayer->id,
                    'team_id' => $cricketTeam->id,
                    'position' => $position,
                ]);

                $cricketUnit = $this->createCricketUnitService->handle($cricketUnitDto);
                $existCricketUnitIds[] = $cricketUnit->id;
            } catch (\Throwable $exception) {
                Log::channel('stderr')->error($exception->getMessage());
            }
        }

        $this->updateCricketUnitStatusService->handle($cricketTeam->id, $existCricketUnitIds);
    }
}
