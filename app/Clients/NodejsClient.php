<?php

namespace App\Clients;

use App\Exceptions\NodejsClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

class NodejsClient
{
    private const CONTEST_ENDPOINT = '/contest';
    private const CONTEST_GAME_LOGS_ENDPOINT = '/contests/%s/game-logs';
    private const CONTEST_PLAYERS_ENDPOINT = '/contests/%s/players';
    private const USER_BALANCE_ENDPOINT = '/users/%s/balance';
    private const USER_TRANSACTION_ENDPOINT = '/users/%s/transaction';

    private ?string $apiUrl;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = config('nodejs.url');
    }

    public function sendContestUpdatePush(array $data): void
    {
        $url = $this->apiUrl . self::CONTEST_ENDPOINT;
        $this->sendRequest($url, $data);
    }

    public function sendGameLogsUpdatePush(array $data, int $contestId): void
    {
        $url = sprintf($this->apiUrl . self::CONTEST_GAME_LOGS_ENDPOINT, $contestId);
        $this->sendRequest($url, $data);
    }

    public function sendUserBalanceUpdatePush(array $data, int $userId): void
    {
        $url = sprintf($this->apiUrl . self::USER_BALANCE_ENDPOINT, $userId);
        $this->sendRequest($url, $data);
    }

    public function sendUserTransactionCreatedPush(array $data, int $userId): void
    {
        $url = sprintf($this->apiUrl . self::USER_TRANSACTION_ENDPOINT, $userId);
        $this->sendRequest($url, $data);
    }

    public function sendContestUnitsUpdatePush(array $data, int $contestId): void
    {
        $url = sprintf($this->apiUrl . self::CONTEST_PLAYERS_ENDPOINT, $contestId);
        $this->sendRequest($url, $data);
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
