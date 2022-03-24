<?php

namespace App\Dto;

use App\Enums\CricketTeamFeedTypeEnum;

class CricketTeamDto
{
    public ?int $id;
    public int $feedId;
    public int $leagueId;
    public string $name;
    public string $nickname;
    public string $alias;
    public ?int $countryId;
    public ?string $logo;
    public CricketTeamFeedTypeEnum $feedType;
}
