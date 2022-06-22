<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'userId' => $this->user_id,
            'username' => $this->user->username,
            'avatar' => FileHelper::getPublicUrl($this->user->avatar),
            'budget' => $this->getBudget(),
            'date' => DateHelper::dateFormatMs($this->created_at),
            'isWinner' => $this->is_winner,
            'place' => $this->place,
            'prize' => (float) $this->prize,
            'score' => (float) $this->team_score,
        ];
    }

    private function getBudget(): float
    {
        return (float) $this->contestUnits()->sum('salary');
    }
}
