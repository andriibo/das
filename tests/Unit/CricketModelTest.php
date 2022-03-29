<?php

namespace Tests\Unit;

use App\Models\CricketTeam;
use App\Models\League;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CricketModelTest extends TestCase
{
    /**
     * Test order process.
     */
    public function testCreateLeague()
    {
        $league = League::factory()
            ->create()
        ;

        $this->assertModelExists($league);
    }

    /**
     * Test order process.
     */
    public function testCreateCricketTeam()
    {
        $league = League::factory()
            ->create()
        ;

        $cricketTeam = CricketTeam::factory()
            ->for($league)
            ->create()
        ;

        $this->assertModelExists($cricketTeam);
    }
}
