<?php

namespace App\Services;

use App\Clients\GoalserveClient;
use App\Exceptions\CricketGoalserveServiceException;

class CricketGoalserveService
{
    public function __construct(
        private readonly GoalserveClient $goalserveClient,
    ) {
    }

    /**
     * @throws CricketGoalserveServiceException
     */
    public function getGoalserveCricketTeams(int $leagueId): array
    {
        try {
            $data = $this->goalserveClient->getCricketTeams($leagueId);

            return $data['squads']['category']['team'] ?? [];
        } catch (\Throwable $exception) {
            throw new CricketGoalserveServiceException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws CricketGoalserveServiceException
     */
    public function getGoalserveCricketPlayer(int $playerId): array
    {
        try {
            $data = $this->goalserveClient->getCricketPlayer($playerId);

            return $data['players']['player'] ?? [];
        } catch (\Throwable $exception) {
            throw new CricketGoalserveServiceException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws CricketGoalserveServiceException
     */
    public function getGoalserveMatches(int $leagueId): array
    {
        try {
            $data = $this->goalserveClient->getMatches($leagueId);

            return $data['fixtures']['category']['match'] ?? [];
        } catch (\Throwable $exception) {
            throw new CricketGoalserveServiceException($exception->getMessage(), $exception->getCode());
        }
    }
}
