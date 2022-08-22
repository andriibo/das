<?php

namespace App\Mappers\Nodejs;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use App\Models\Contests\ContestUser;
use NodeJsClient\Dto\ContestUserDto;

class ContestUserMapper
{
    public function map(ContestUser $contestUser): ContestUserDto
    {
        $contestUserDto = new ContestUserDto();

        $contestUserDto->id = $contestUser->id;
        $contestUserDto->title = $contestUser->title;
        $contestUserDto->userId = $contestUser->user_id;
        $contestUserDto->username = $contestUser->user->username;
        $contestUserDto->avatar = FileHelper::getPublicUrl($contestUser->user->avatar);
        $contestUserDto->budget = $contestUser->contestUnits()->sum('salary');
        $contestUserDto->date = DateHelper::dateFormatMs($contestUser->created_at);
        $contestUserDto->isWinner = $contestUser->is_winner;
        $contestUserDto->place = $contestUser->place;
        $contestUserDto->prize = (float) $contestUser->prize;
        $contestUserDto->score = (float) $contestUser->team_score;

        return $contestUserDto;
    }
}
