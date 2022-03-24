<?php

namespace Tests\Unit;

use App\Services\CricketGoalserveService;
use function resolve;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CricketTeamTest extends TestCase
{
    private int $leagueId = 1015;
    private int $playerId = 669855;

    public function testGoalserveCricketLeague(): void
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
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
    }

    public function testGoalserveCricketPlayer(): void
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $response = $cricketGoalserveService->getGoalserveCricketPlayer($this->playerId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('image', $response);
        $this->assertArrayHasKey('playing_role', $response);
    }

    public function testGoalserveMatches(): void
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $response = $cricketGoalserveService->getGoalserveMatches($this->leagueId);

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
}
