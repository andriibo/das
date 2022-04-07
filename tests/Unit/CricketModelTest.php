<?php

namespace Tests\Unit;

use App\Models\CricketGameSchedule;
use App\Models\CricketGameStat;
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
        $cricketTeam = $this->createCricketTeam();
        $cricketPlayer = $this->createCricketPlayer();

        $cricketUnit = CricketUnit::factory()
            ->for($cricketTeam)
            ->for($cricketPlayer)
            ->create()
        ;

        $this->assertModelExists($cricketUnit);
    }

    public function testCreateCricketGameSchedule()
    {
        $cricketGameSchedule = $this->createCricketGameSchedule();

        $this->assertModelExists($cricketGameSchedule);
    }

    public function testCreateCricketGameStat()
    {
        $league = $this->createCricketLeague();
        $homeTeam = $this->createCricketTeam();
        $awayTeam = $this->createCricketTeam();

        $cricketGameSchedule = CricketGameSchedule::factory()
            ->for($league)
            ->for($homeTeam, 'homeTeam')
            ->for($awayTeam, 'awayTeam')
            ->create()
        ;

        $cricketGameStat = CricketGameStat::factory()
            ->for($cricketGameSchedule)
            ->create()
        ;

        $this->assertModelExists($cricketGameStat);
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
