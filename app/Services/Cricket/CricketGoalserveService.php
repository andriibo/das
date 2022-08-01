<?php

namespace App\Services\Cricket;

use App\Clients\GoalserveClient;
use App\Exceptions\CricketGoalserveServiceException;
use App\Services\SendSlackNotificationService;

class CricketGoalserveService
{
    public function __construct(
        private readonly GoalserveClient $goalserveClient,
        private readonly SendSlackNotificationService $sendSlackNotificationService,
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
            $message = $exception->getMessage();
            $this->sendSlackNotificationService->handle($message, __METHOD__, ['leagueId' => $leagueId]);

            throw new CricketGoalserveServiceException($message, $exception->getCode());
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
            $message = $exception->getMessage();
            $this->sendSlackNotificationService->handle($message, __METHOD__, ['playerId' => $playerId]);

            throw new CricketGoalserveServiceException($message, $exception->getCode());
        }
    }

    /**
     * @throws CricketGoalserveServiceException
     */
    public function getGoalserveCricketMatches(int $leagueId): array
    {
        try {
            $data = $this->goalserveClient->getCricketMatches($leagueId);

            return $data['fixtures']['category']['match'] ?? [];
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            $this->sendSlackNotificationService->handle($message, __METHOD__, ['leagueId' => $leagueId]);

            throw new CricketGoalserveServiceException($message, $exception->getCode());
        }
    }

    /**
     * @throws CricketGoalserveServiceException
     */
    public function getGoalserveGameStats(string $date, int $leagueFeedId, string $gameScheduleFeedId): array
    {
        try {
            $data = $this->goalserveClient->getGameStats($date);
            if (isset($data['scores']['category']) && is_array($data['scores']['category'])) {
                foreach ($data['scores']['category'] as $league) {
                    if ($league['id'] != $leagueFeedId) {
                        continue;
                    }
                    if ($league['match']['id'] === $gameScheduleFeedId) {
                        return $league;
                    }
                }
            }

            return [];
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            $this->sendSlackNotificationService->handle(
                $message,
                __METHOD__,
                [
                    'date' => $date,
                    'leagueFeedId' => $leagueFeedId,
                    'gameScheduleFeedId' => $gameScheduleFeedId,
                ]
            );

            throw new CricketGoalserveServiceException($message, $exception->getCode());
        }
    }
}
