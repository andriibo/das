<?php

namespace Tests\Unit;

use App\Clients\GoalserveClient;
use App\Services\Cricket\CricketGoalserveService;
use App\Services\SendSlackNotificationService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class GoalserveClientTest extends TestCase
{
    private int $leagueId = 1015;
    private int $playerId = 669855;
    private string $gameDate = '01.04.2022';
    private string $gameScheduleFeedId = '13071977374';
    private string $leagueFeedId = '1015';

    public function testGoalserveGetCricketTeams(): void
    {
        $mockGoalserveClient = $this->mock(GoalserveClient::class);
        $mockSendSlackNotificationService = $this->mock(SendSlackNotificationService::class);
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.teams.json')), true);
        $mockGoalserveClient->shouldReceive('getCricketTeams')
            ->with($this->leagueId)
            ->andReturn($mockResponse)
        ;
        $mockSendSlackNotificationService->shouldReceive('handle');

        $this->assertInstanceOf(GoalserveClient::class, $mockGoalserveClient);
        $this->assertInstanceOf(SendSlackNotificationService::class, $mockSendSlackNotificationService);

        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = new CricketGoalserveService($mockGoalserveClient, $mockSendSlackNotificationService);
        $response = $cricketGoalserveService->getGoalserveCricketTeams($this->leagueId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);

        $firstTeam = $response[0];
        $this->assertArrayHasKey('id', $firstTeam);
        $this->assertArrayHasKey('name', $firstTeam);
        $this->assertArrayHasKey('player', $firstTeam);

        $firstTeamPlayer = $firstTeam['player'][0];
        $this->assertArrayHasKey('id', $firstTeamPlayer);
        $this->assertArrayHasKey('name', $firstTeamPlayer);
        $this->assertArrayHasKey('role', $firstTeamPlayer);
    }

    public function testGoalserveGetCricketPlayer(): void
    {
        $mockGoalserveClient = $this->mock(GoalserveClient::class);
        $mockSendSlackNotificationService = $this->mock(SendSlackNotificationService::class);
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.player.json')), true);
        $mockGoalserveClient->shouldReceive('getCricketPlayer')
            ->with($this->playerId)
            ->andReturn($mockResponse)
        ;

        $mockSendSlackNotificationService->shouldReceive('handle');

        $this->assertInstanceOf(GoalserveClient::class, $mockGoalserveClient);
        $this->assertInstanceOf(SendSlackNotificationService::class, $mockSendSlackNotificationService);

        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = new CricketGoalserveService($mockGoalserveClient, $mockSendSlackNotificationService);
        $response = $cricketGoalserveService->getGoalserveCricketPlayer($this->playerId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('image', $response);
    }

    public function testGoalserveGetCricketMatches(): void
    {
        $mockGoalserveClient = $this->mock(GoalserveClient::class);
        $mockSendSlackNotificationService = $this->mock(SendSlackNotificationService::class);
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.matches.json')), true);
        $mockGoalserveClient->shouldReceive('getCricketMatches')
            ->with($this->leagueId)
            ->andReturn($mockResponse)
        ;

        $mockSendSlackNotificationService->shouldReceive('handle');

        $this->assertInstanceOf(GoalserveClient::class, $mockGoalserveClient);
        $this->assertInstanceOf(SendSlackNotificationService::class, $mockSendSlackNotificationService);

        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = new CricketGoalserveService($mockGoalserveClient, $mockSendSlackNotificationService);
        $response = $cricketGoalserveService->getGoalserveCricketMatches($this->leagueId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);

        $firstMatch = $response[0];
        $this->assertArrayHasKey('id', $firstMatch);
        $this->assertArrayHasKey('date', $firstMatch);
        $this->assertArrayHasKey('time', $firstMatch);
        $this->assertArrayHasKey('localteam', $firstMatch);
        $this->assertArrayHasKey('visitorteam', $firstMatch);

        $firstMatchLocalTeam = $firstMatch['localteam'];
        $firstMatchVisitorTeam = $firstMatch['visitorteam'];
        $this->assertArrayHasKey('id', $firstMatchLocalTeam);
        $this->assertArrayHasKey('id', $firstMatchVisitorTeam);
        $this->assertArrayHasKey('totalscore', $firstMatchLocalTeam);
        $this->assertArrayHasKey('totalscore', $firstMatchVisitorTeam);
    }

    public function testGoalserveGetGameStats(): void
    {
        $mockGoalserveClient = $this->mock(GoalserveClient::class);
        $mockSendSlackNotificationService = $this->mock(SendSlackNotificationService::class);
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.game.stats.json')), true);
        $mockGoalserveClient->shouldReceive('getGameStats')
            ->with($this->gameDate)
            ->andReturn($mockResponse)
        ;

        $mockSendSlackNotificationService->shouldReceive('handle');

        $this->assertInstanceOf(GoalserveClient::class, $mockGoalserveClient);
        $this->assertInstanceOf(SendSlackNotificationService::class, $mockSendSlackNotificationService);

        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = new CricketGoalserveService($mockGoalserveClient, $mockSendSlackNotificationService);
        $response = $cricketGoalserveService->getGoalserveGameStats($this->gameDate, $this->leagueFeedId, $this->gameScheduleFeedId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('match', $response);
    }
}
