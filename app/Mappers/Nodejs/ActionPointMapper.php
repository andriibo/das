<?php

namespace App\Mappers\Nodejs;

use App\Models\ActionPoint;
use NodeJsClient\Dto\ActionPointDto;

class ActionPointMapper
{
    public function map(ActionPoint $actionPoint): ActionPointDto
    {
        $actionPointDto = new ActionPointDto();

        $actionPointDto->id = $actionPoint->id;
        $actionPointDto->name = $actionPoint->name;
        $actionPointDto->sportId = $actionPoint->sport_id;
        $actionPointDto->alias = $actionPoint->alias;
        $actionPointDto->gameLogTemplate = $actionPoint->game_log_template;
        $actionPointDto->values = $actionPoint->values;

        return $actionPointDto;
    }
}
