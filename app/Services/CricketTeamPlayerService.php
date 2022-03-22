<?php

namespace App\Services;

use App\Dto\CricketTeamPlayerDto;
use App\Models\CricketTeamPlayer;
use App\Repositories\CricketTeamPlayerRepository;

class CricketTeamPlayerService
{
    public function __construct(
        private readonly CricketTeamPlayerRepository $cricketTeamPlayerRepository
    ) {
    }

    public function storeCricketTeamPlayer(CricketTeamPlayerDto $cricketTeamPlayerDto): CricketTeamPlayer
    {
        return $this->cricketTeamPlayerRepository->updateOrCreate([
            'cricket_player_id' => $cricketTeamPlayerDto->cricketPlayerId,
            'cricket_team_id' => $cricketTeamPlayerDto->cricketTeamId,
        ], ['playing_role' => $cricketTeamPlayerDto->playingRole?->value]);
    }
}
