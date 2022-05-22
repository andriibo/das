<?php

namespace App\Services;

use App\Dto\CricketPlayerDto;
use App\Models\CricketPlayer;
use App\Repositories\CricketPlayerRepository;

class CricketPlayerService
{
    public function __construct(
        private readonly CricketPlayerRepository $cricketPlayerRepository
    ) {
    }

    public function storeCricketPlayer(CricketPlayerDto $cricketPlayerDto): CricketPlayer
    {
        return $this->cricketPlayerRepository->updateOrCreate([
            'feed_id' => $cricketPlayerDto->feedId,
            'feed_type' => $cricketPlayerDto->feedType->name,
        ], [
            'first_name' => $cricketPlayerDto->firstName,
            'last_name' => $cricketPlayerDto->lastName,
            'injury_status' => $cricketPlayerDto->injuryStatus->name,
        ]);
    }
}
