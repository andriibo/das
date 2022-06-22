<?php

namespace App\Http\Resources;

use App\Factories\SportConfigFactory;
use App\Helpers\FileHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestUnitResource extends JsonResource
{
    public function toArray($request): array
    {
        $unit = $this->cricketUnit;
        $sportConfig = SportConfigFactory::getConfig($this->sport_id);

        return [
            'id' => $this->id,
            'playerId' => $unit->player->id,
            'totalFantasyPointsPerGame' => (float) $unit->player->total_fantasy_points_per_game,
            'salary' => (float) $this->salary,
            'score' => (float) $this->score,
            'fullname' => $unit->player->getFullName(),
            'photo' => FileHelper::getPublicUrl($unit->player->photo),
            'teamId' => $this->team_id,
            'sportId' => $this->sport_id,
            'position' => new PositionResource($sportConfig->positions[$unit->position] ?? null),
        ];
    }
}
