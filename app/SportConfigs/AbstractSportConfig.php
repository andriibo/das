<?php

namespace App\SportConfigs;

class AbstractSportConfig
{
    public int $playersInTeam = 11;

    public int $minTeams = 3;

    public int $gameDuration = 7200;

    /**
     * @var PositionConfig[]
     */
    public array $positions;
}
