<?php

namespace App\Mappers;

use App\Dto\CricketPlayerDto;
use App\Enums\CricketPlayerFeedTypeEnum;
use App\Enums\CricketPlayerInjuryStatusEnum;
use App\Enums\CricketPlayerSportIdEnum;

class CricketPlayerMapper
{
    public function map(array $data): CricketPlayerDto
    {
        $cricketPlayerDto = new CricketPlayerDto();

        $cricketPlayerDto->feedType = CricketPlayerFeedTypeEnum::goalserve;
        $cricketPlayerDto->feedId = $data['id'];
        $cricketPlayerDto->sportId = CricketPlayerSportIdEnum::Cricket;
        $cricketPlayerDto->firstName = $data['name'] ?? '';
        $cricketPlayerDto->lastName = $data['name'] ?? '';
        $cricketPlayerDto->imageName = $data['image_name'] ?? null;
        $cricketPlayerDto->injuryStatus = CricketPlayerInjuryStatusEnum::normal;
        $cricketPlayerDto->salary = 0;
        $cricketPlayerDto->autoSalary = 0;
        $cricketPlayerDto->totalFantasyPoints = 0;
        $cricketPlayerDto->totalFantasyPointsPerGame = 0;

        return $cricketPlayerDto;
    }
}
