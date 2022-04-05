<?php

namespace App\Clients;

use App\Exceptions\GoalserveClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GoalserveClient
{
    private string $apiUrl = 'https://www.goalserve.com';
    private Client $client;
    private ?string $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('goalserve.api_key');
    }

    public function getCricketTeams(int $leagueId): array
    {
        $url = "/cricketfixtures/intl/{$leagueId}_squads?json=1";

        $this->sendRequestGet($url);
    }

    public function getCricketPlayer(int $playerId): array
    {
        $url = "/cricket/profile?id={$playerId}&json=1";

        $this->sendRequestGet($url);
    }

    public function getCricketMatches(int $leagueId): array
    {
        $url = "/cricketfixtures/intl/{$leagueId}?json=1";

        $this->sendRequestGet($url);
    }

    public function getGameStats(string $date): array
    {
        $url = "/cricket/livescore?date={$date}&json=1";

        $this->sendRequestGet($url);
    }

    private function sendRequestGet(string $url): array
    {
        $endpoint = "{$this->apiUrl}/getfeed/{$this->apiKey}/{$url}";

        try {
            $response = $this->client->get($endpoint);
            $data = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new GoalserveClientException('Can\'t parse json - ' . json_last_error_msg());
            }

            return $data;
        } catch (ClientException $clientException) {
            throw new GoalserveClientException($clientException->getMessage(), $clientException->getCode());
        }
    }
}
