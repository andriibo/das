<?php

namespace App\Mappers;

use App\Dto\CricketTeamDto;
use App\Enums\FeedTypeEnum;

class CricketTeamMapper
{
    public function map(array $data, int $leagueId): CricketTeamDto
    {
        $cricketTeamDto = new CricketTeamDto();

        $cricketTeamDto->feedId = $data['id'];
        $cricketTeamDto->leagueId = $leagueId;
        $cricketTeamDto->name = $data['name'] ?? '';
        $cricketTeamDto->nickname = $data['nickname'] ?? '';
        $cricketTeamDto->alias = trim(substr(strtoupper($data['name']), 0, 3));
        $cricketTeamDto->countryId = $data['country_id'] ?? null;
        $cricketTeamDto->logo = $data['logo'] ?? null;
        $cricketTeamDto->feedType = FeedTypeEnum::goalserve;

        return $cricketTeamDto;
    }
}
