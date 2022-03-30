<?php

namespace Tests\Unit;

use App\Clients\GoalserveClient;
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

    public function testGoalserveGetCricketTeams(): void
    {
        $mockGoalserveClient = $this->mock(GoalserveClient::class);
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.teams.json')), true);
        $mockGoalserveClient->shouldReceive('getCricketTeams')
            ->with($this->leagueId)
            ->andReturn($mockResponse)
        ;

        /* @var $mockGoalserveClient GoalserveClient */
        $response = $mockGoalserveClient->getCricketTeams($this->leagueId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('squads', $response);
        $this->assertArrayHasKey('category', $response['squads']);
        $this->assertArrayHasKey('team', $response['squads']['category']);
        $this->assertNotEmpty($response['squads']['category']['team']);

        $firstTeam = $response['squads']['category']['team'][0];
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
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.player.json')), true);
        $mockGoalserveClient->shouldReceive('getCricketPlayer')
            ->with($this->playerId)
            ->andReturn($mockResponse)
        ;

        /* @var $mockGoalserveClient GoalserveClient */
        $response = $mockGoalserveClient->getCricketPlayer($this->playerId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('players', $response);
        $this->assertArrayHasKey('player', $response['players']);
        $player = $response['players']['player'];

        $this->assertArrayHasKey('name', $player);
        $this->assertArrayHasKey('image', $player);
    }

    public function testGoalserveGetCricketMatches(): void
    {
        $mockGoalserveClient = $this->mock(GoalserveClient::class);
        $mockResponse = json_decode(File::get(base_path('tests/stubs/cricket.matches.json')), true);
        $mockGoalserveClient->shouldReceive('getMatches')
            ->with($this->leagueId)
            ->andReturn($mockResponse)
        ;

        /* @var $mockGoalserveClient GoalserveClient */
        $response = $mockGoalserveClient->getMatches($this->leagueId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('fixtures', $response);
        $this->assertArrayHasKey('category', $response['fixtures']);
        $this->assertArrayHasKey('match', $response['fixtures']['category']);
        $this->assertNotEmpty($response['fixtures']['category']['match']);

        $firstMatch = $response['fixtures']['category']['match'][0];
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
}
