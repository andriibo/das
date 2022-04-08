<?php

namespace App\Dto;

class CricketGameLogDto
{
    public ?int $id;
    public int $gameScheduleId;
    public int $playerId;
    public int $actionPointId;
    public float $value;
    public ?string $createdAt;
    public ?string $updatedAt;
}
