<?php

namespace App\Mappers\Nodejs;

use FantasySports\SportConfig\Classes\PositionConfig;
use NodeJsClient\Dto\PositionDto;

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
