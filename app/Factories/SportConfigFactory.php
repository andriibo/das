<?php

namespace App\Factories;

use App\Enums\SportIdEnum;
use App\Exceptions\SportConfigFactoryException;
use App\SportConfigs\AbstractSportConfig;
use App\SportConfigs\CricketConfig;
use App\SportConfigs\SoccerConfig;
use Illuminate\Http\Response;

class SportConfigFactory
{
    /**
     * @throws SportConfigFactoryException
     */
    public static function getConfig(int $sportId): AbstractSportConfig
    {
        if ($sportId == SportIdEnum::soccer->value) {
            return new SoccerConfig();
        }

        if ($sportId == SportIdEnum::cricket->value) {
            return new CricketConfig();
        }

        throw new SportConfigFactoryException('Could not find config for this sport', Response::HTTP_NOT_FOUND);
    }
}
