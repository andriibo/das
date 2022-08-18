<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrizePlaceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'places' => $this->places,
            'prize' => $this->prize,
            'voucher' => $this->voucher,
            'badgeId' => $this->badgeId,
            'numBadges' => $this->numBadges,
            'winners' => ContestUserResource::collection($this->winners),
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}
