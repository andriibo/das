<?php

namespace App\Clients;

use App\Exceptions\NodejsClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

class NodejsClient
{
    private const CONTEST_UPDATED = 'contest-update';
    private const CONTEST_GAME_LOG_UPDATED = 'game-log-update';
    private const CONTEST_GAMES_UPDATED = 'game-update';
    private const CONTEST_USERS_UPDATED = 'users-update';
    private const CONTEST_UNITS_UPDATED = 'units-update';

    private ?string $apiUrl;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = config('nodejs.url');
    }

    public function sendContestUpdatePush(array $data): void
    {
        $url = $this->apiUrl . '/contest';
        $formParams = [
            'type' => self::CONTEST_UPDATED,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendGameLogsUpdatePush(array $data, int $contestId): void
    {
        $url = $this->apiUrl . '/contest/' . $contestId;
        $formParams = [
            'type' => self::CONTEST_GAME_LOG_UPDATED,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendContestUnitsUpdatePush(array $data, int $contestId): void
    {
        $url = $this->apiUrl . '/contest/' . $contestId;
        $formParams = [
            'type' => self::CONTEST_UNITS_UPDATED,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendContestUsersUpdatePush(array $data, int $contestId): void
    {
        $url = $this->apiUrl . '/contest/' . $contestId;
        $formParams = [
            'type' => self::CONTEST_USERS_UPDATED,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendGameSchedulesUpdatePush(array $data, int $contestId): void
    {
        $url = $this->apiUrl . '/contest/' . $contestId;
        $formParams = [
            'type' => self::CONTEST_GAMES_UPDATED,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    /**
     * @throws NodejsClientException
     */
    private function sendRequest(string $url, array $formParams = []): void
    {
        $options = [RequestOptions::JSON => $formParams];

        try {
            $this->client->post($url, $options);
        } catch (ClientException $clientException) {
            throw new NodejsClientException($clientException->getMessage(), $clientException->getCode());
        }
    }
}
