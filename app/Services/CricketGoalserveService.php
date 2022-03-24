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
            return $this->goalserveClient->getCricketTeams($leagueId);
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
            return $this->goalserveClient->getCricketPlayer($playerId);
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
            return $this->goalserveClient->getMatches($leagueId);
        } catch (\Throwable $exception) {
            throw new CricketGoalserveServiceException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws CricketGoalserveServiceException
     */
    public function getGoalserveUnitStats(string $date): array
    {
        try {
            return $this->goalserveClient->getUnitStats($date);
        } catch (\Throwable $exception) {
            throw new CricketGoalserveServiceException($exception->getMessage(), $exception->getCode());
        }
    }
}
