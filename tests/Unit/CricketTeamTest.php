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
        $response = $cricketGoalserveService->getGoalserveCricketLeague($this->leagueId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('squads', $response);
        $this->assertArrayHasKey('category', $response['squads']);
        $this->assertArrayHasKey('team', $response['squads']['category']);
    }

    public function testGoalserveCricketPlayer(): void
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $response = $cricketGoalserveService->getGoalserveCricketPlayer($this->playerId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('players', $response);
        $this->assertArrayHasKey('player', $response['players']);
    }

    public function testGoalserveMatches(): void
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $response = $cricketGoalserveService->getGoalserveMatches($this->leagueId);

        $this->assertIsNotObject($response);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('fixtures', $response);
        $this->assertArrayHasKey('category', $response['fixtures']);
        $this->assertArrayHasKey('match', $response['fixtures']['category']);
    }
}
