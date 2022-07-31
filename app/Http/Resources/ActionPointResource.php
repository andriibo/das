<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionPointResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sportId' => $this->sport_id,
            'alias' => $this->alias,
            'gameLogTemplate' => $this->game_log_template,
            'values' => (object) $this->values,
        ];
    }
}
