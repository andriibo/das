<?php

namespace App\Mappers;

use App\Dto\CricketTeamDto;
use App\Enums\CricketTeamFeedTypeEnum;

class CricketTeamMapper
{
    public function map(array $data, int $leagueId): CricketTeamDto
    {
        $cricketTeamDto = new CricketTeamDto();

        $cricketTeamDto->feedId = $data['id'] ?? null;
        $cricketTeamDto->leagueId = $leagueId;
        $cricketTeamDto->name = $data['name'] ?? '';
        $cricketTeamDto->nickname = $data['nickname'] ?? '';
        $cricketTeamDto->alias = $data['alias'] ?? '';
        $cricketTeamDto->countryId = $data['country_id'] ?? 0;
        $cricketTeamDto->logo = $data['logo'] ?? null;
        $cricketTeamDto->feedType = CricketTeamFeedTypeEnum::goalserve;

        return $cricketTeamDto;
    }
}
