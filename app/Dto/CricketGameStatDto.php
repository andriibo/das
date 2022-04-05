<?php

namespace App\Dto;

class CricketGameStatDto
{
    public ?int $id;
    public int $cricketGameScheduleId;
    public array $rawStat;
    public ?string $createdAt;
    public ?string $updatedAt;
}
