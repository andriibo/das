<?php

namespace App\Clients;

use App\Exceptions\NodejsClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

class NodejsClient
{
    private const CONTESTS_ENDPOINT = '/contests';
    private const CONTEST_GAME_LOGS_ENDPOINT = '/contests/%s/game-logs';
    private const CONTEST_PLAYERS_ENDPOINT = '/contests/%s/players';
    private const USER_BALANCE_ENDPOINT = '/users/%s/balance';
    private const USER_TRANSACTIONS_ENDPOINT = '/users/%s/transactions';

    private const CONTESTS_UPDATED_TYPE = 'contestsUpdated';
    private const CONTEST_GAME_LOGS_UPDATED_TYPE = 'contestGameLogsUpdated';
    private const CONTEST_PLAYERS_UPDATED_TYPE = 'contestPlayersUpdated';
    private const USER_BALANCE_UPDATED_TYPE = 'userBalanceUpdated';
    private const USER_TRANSACTIONS_UPDATED_TYPE = 'userTransactionsUpdated';

    private ?string $apiUrl;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = config('nodejs.url');
    }

    public function sendContestUpdatePush(array $data): void
    {
        $url = $this->apiUrl . self::CONTESTS_ENDPOINT;
        $formParams = [
            'type' => self::CONTESTS_UPDATED_TYPE,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendContestUnitsUpdatePush(array $data, int $contestId): void
    {
        $url = sprintf($this->apiUrl . self::CONTEST_PLAYERS_ENDPOINT, $contestId);
        $formParams = [
            'type' => self::CONTEST_PLAYERS_UPDATED_TYPE,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendGameLogsUpdatePush(array $data, int $contestId): void
    {
        $url = sprintf($this->apiUrl . self::CONTEST_GAME_LOGS_ENDPOINT, $contestId);
        $formParams = [
            'type' => self::CONTEST_GAME_LOGS_UPDATED_TYPE,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendUserBalanceUpdatePush(array $data, int $userId): void
    {
        $url = sprintf($this->apiUrl . self::USER_BALANCE_ENDPOINT, $userId);
        $formParams = [
            'type' => self::USER_BALANCE_UPDATED_TYPE,
            'payload' => $data,
        ];

        $this->sendRequest($url, $formParams);
    }

    public function sendUserTransactionCreatedPush(array $data, int $userId): void
    {
        $url = sprintf($this->apiUrl . self::USER_TRANSACTIONS_ENDPOINT, $userId);
        $formParams = [
            'type' => self::USER_TRANSACTIONS_UPDATED_TYPE,
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
