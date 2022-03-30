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
        $endpoint = "{$this->apiUrl}/getfeed/{$this->apiKey}/cricketfixtures/intl/{$leagueId}_squads?json=1";

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

    public function getCricketPlayer(int $playerId): array
    {
        $endpoint = "{$this->apiUrl}/getfeed/{$this->apiKey}/cricket/profile?id={$playerId}&json=1";

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

    public function getCricketMatches(int $leagueId): array
    {
        $endpoint = "{$this->apiUrl}/getfeed/{$this->apiKey}/cricketfixtures/intl/{$leagueId}?json=1";

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
