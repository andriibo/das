<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class GameScheduleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'startDate' => DateHelper::dateFormatMs($this->game_date),
            'awayTeamScore' => $this->away_team_score,
            'homeTeamScore' => $this->home_team_score,
            'awayTeam' => new TeamResource($this->awayTeam),
            'homeTeam' => new TeamResource($this->homeTeam),
        ];
    }
}
