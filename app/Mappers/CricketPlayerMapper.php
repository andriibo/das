<?php

namespace App\Mappers;

use App\Dto\CricketPlayerDto;
use App\Enums\CricketPlayerFeedTypeEnum;
use App\Enums\CricketPlayerInjuryStatusEnum;
use App\Enums\CricketPlayerSportEnum;

class CricketPlayerMapper
{
    public function map(array $data): CricketPlayerDto
    {
        $cricketPlayerDto = new CricketPlayerDto();

        $cricketPlayerDto->feedType = CricketPlayerFeedTypeEnum::goalserve;
        $cricketPlayerDto->feedId = $data['id'];
        $cricketPlayerDto->sport = CricketPlayerSportEnum::cricket;
        $cricketPlayerDto->firstName = $data['name'] ?? '';
        $cricketPlayerDto->lastName = $data['name'] ?? '';
        $cricketPlayerDto->photo = $data['photo'] ?? null;
        $cricketPlayerDto->injuryStatus = CricketPlayerInjuryStatusEnum::normal;
        $cricketPlayerDto->salary = 0;
        $cricketPlayerDto->autoSalary = 0;
        $cricketPlayerDto->totalFantasyPoints = 0;
        $cricketPlayerDto->totalFantasyPointsPerGame = 0;

        return $cricketPlayerDto;
    }
}
