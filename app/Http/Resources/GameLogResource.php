<?php

namespace App\Http\Resources;

use App\Helpers\ActionPointHelper;
use App\Services\GetContestActionPointService;
use Illuminate\Http\Resources\Json\JsonResource;

class GameLogResource extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $getContestActionPointService GetContestActionPointService */
        $getContestActionPointService = resolve(GetContestActionPointService::class);
        $contestId = $this->id;
        $actionPoint = $getContestActionPointService->handle($contestId, $this->action_point_id);

        return [
            'playerId' => $this->unit_id,
            'playerName' => $this->unit->player->getFullName(),
            'score' => ActionPointHelper::getScore($this->value, $actionPoint->values, $this->unit->position),
            'message' => $actionPoint->game_log_template,
        ];
    }
}
