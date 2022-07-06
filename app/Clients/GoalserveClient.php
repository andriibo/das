<?php

namespace App\Clients;

use App\Exceptions\GoalserveClientException;
use App\Repositories\FeedConfigRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GoalserveClient
{
    private string $apiUrl = 'https://www.goalserve.com';
    private Client $client;
    private static ?string $apiKey = null;

    public function __construct(private readonly FeedConfigRepository $feedConfigRepository)
    {
        $this->client = new Client();
    }

    public function getCricketTeams(int $leagueId): array
    {
        $url = "cricketfixtures/intl/{$leagueId}_squads?json=1";

        return $this->sendRequest($url);
    }

    public function getCricketPlayer(int $playerId): array
    {
        $url = "cricket/profile?id={$playerId}&json=1";

        return $this->sendRequest($url);
    }

    public function getCricketMatches(int $leagueId): array
    {
        $url = "cricketfixtures/intl/{$leagueId}?json=1";

        return $this->sendRequest($url);
    }

    public function getGameStats(string $date): array
    {
        $url = "cricket/livescore?date={$date}&json=1";

        return $this->sendRequest($url);
    }

    private function sendRequest(string $url, string $method = 'GET', array $options = []): array
    {
        $apiKey = $this->getGoalServeApiKey();
        $endpoint = "{$this->apiUrl}/getfeed/{$apiKey}/{$url}";

        try {
            $response = $this->client->request($method, $endpoint, $options);
            $data = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new GoalserveClientException('Can\'t parse json - ' . json_last_error_msg());
            }

            return $data;
        } catch (ClientException $clientException) {
            throw new GoalserveClientException($clientException->getMessage(), $clientException->getCode());
        }
    }

    private function getGoalServeApiKey(): string
    {
        if (is_null($this::$apiKey)) {
            $feedConfig = $this->feedConfigRepository->getGoalserveConfig();
            $this::$apiKey = $feedConfig->params['accessKey'];
        }

        return $this::$apiKey;
    }
}
