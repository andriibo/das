<?php

namespace App\Dto;

class CricketUnitStatDto
{
    public ?int $id;
    public int $cricketGameScheduleId;
    public int $cricketPlayerId;
    public int $cricketTeamId;
    public string $stat;
    public string $dateUpdated;
}
