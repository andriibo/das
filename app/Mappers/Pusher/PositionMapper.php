<?php

namespace App\Mappers\Pusher;

use FantasySports\SportConfig\Classes\PositionConfig;
use Pusher\Dto\PositionDto;

class PositionMapper
{
    public function map(PositionConfig $positionConfig): PositionDto
    {
        $positionDto = new PositionDto();

        $positionDto->name = $positionConfig->name;
        $positionDto->alias = $positionConfig->shortName;

        return $positionDto;
    }
}
