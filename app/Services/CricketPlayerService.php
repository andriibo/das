<?php

namespace App\Services;

use App\Dto\CricketPlayerDto;
use App\Models\CricketPlayer;
use App\Repositories\CricketPlayerRepository;
use Illuminate\Database\Eloquent\Collection;

class CricketPlayerService
{
    public function __construct(
        private readonly CricketPlayerRepository $cricketPlayerRepository
    ) {
    }

    /**
     * @return Collection|CricketPlayer[]
     */
    public function getCricketPlayers(): Collection
    {
        return $this->cricketPlayerRepository->getList();
    }

    public function getCricketPlayerByFeedId(string $feedId): CricketPlayer
    {
        return $this->cricketPlayerRepository->getByFeedId($feedId);
    }

    public function storeCricketPlayer(CricketPlayerDto $cricketPlayerDto): CricketPlayer
    {
        return $this->cricketPlayerRepository->updateOrCreate([
            'feed_id' => $cricketPlayerDto->feedId,
            'feed_type' => $cricketPlayerDto->feedType->name,
        ], [
            'first_name' => $cricketPlayerDto->firstName,
            'last_name' => $cricketPlayerDto->lastName,
            'sport_id' => $cricketPlayerDto->sport->name,
            'injury_status' => $cricketPlayerDto->injuryStatus->name,
        ]);
    }
}
