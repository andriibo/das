<?php

namespace Tests\Unit;

use App\Models\CricketGameSchedule;
use App\Models\CricketGameStats;
use App\Models\CricketPlayer;
use App\Models\CricketTeam;
use App\Models\CricketUnit;
use App\Models\CricketUnitStats;
use App\Models\League;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CricketModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateLeague()
    {
        $league = $this->createCricketLeague();
        $this->assertModelExists($league);
    }

    public function testCreateCricketTeam()
    {
        $cricketTeam = $this->createCricketTeam();
        $this->assertModelExists($cricketTeam);
    }

    public function testCreateCricketPlayer()
    {
        $cricketPlayer = $this->createCricketPlayer();
        $this->assertModelExists($cricketPlayer);
    }

    public function testCreateCricketUnit()
    {
        $team = $this->createCricketTeam();
        $player = $this->createCricketPlayer();

        $cricketUnit = CricketUnit::factory()
            ->for($team, 'team')
            ->for($player, 'player')
            ->create()
        ;

        $this->assertModelExists($cricketUnit);
    }

    public function testCreateCricketGameSchedule()
    {
        $cricketGameSchedule = $this->createCricketGameSchedule();

        $this->assertModelExists($cricketGameSchedule);
    }

    public function testCreateCricketGameStats()
    {
        $league = $this->createCricketLeague();
        $homeTeam = $this->createCricketTeam();
        $awayTeam = $this->createCricketTeam();

        $gameSchedule = CricketGameSchedule::factory()
            ->for($league)
            ->for($homeTeam, 'homeTeam')
            ->for($awayTeam, 'awayTeam')
            ->create()
        ;

        $gameStats = CricketGameStats::factory()
            ->for($gameSchedule, 'gameSchedule')
            ->create()
        ;

        $this->assertModelExists($gameStats);
    }

    public function testCreateCricketUnitStats()
    {
        $gameSchedule = $this->createCricketGameSchedule();
        $team = $this->createCricketTeam();
        $player = $this->createCricketPlayer();

        $cricketUnitStats = CricketUnitStats::factory()
            ->for($gameSchedule, 'gameSchedule')
            ->for($player, 'player')
            ->for($team, 'team')
            ->create()
        ;

        $this->assertModelExists($cricketUnitStats);
    }

    private function createCricketLeague(): League
    {
        return League::factory()
            ->create()
            ;
    }

    private function createCricketTeam(): CricketTeam
    {
        $league = $this->createCricketLeague();

        return CricketTeam::factory()
            ->for($league)
            ->create()
            ;
    }

    private function createCricketPlayer(): CricketPlayer
    {
        return CricketPlayer::factory()
            ->create()
            ;
    }

    private function createCricketGameSchedule()
    {
        $league = $this->createCricketLeague();
        $homeTeam = $this->createCricketTeam();
        $awayTeam = $this->createCricketTeam();

        return CricketGameSchedule::factory()
            ->for($league)
            ->for($homeTeam, 'homeTeam')
            ->for($awayTeam, 'awayTeam')
            ->create()
        ;
    }
}
