<?php

namespace App\Dto;

class CricketGameStatsDto
{
    public ?int $id;
    public int $cricketGameScheduleId;
    public array $rawStats;
    public ?string $createdAt;
    public ?string $updatedAt;
}
