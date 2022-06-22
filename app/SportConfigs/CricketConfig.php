<?php

namespace App\SportConfigs;

class CricketConfig extends AbstractSportConfig
{
    public function __construct()
    {
        $this->positions = [
            PositionConfig::CRICKET_BOWLER => new PositionConfig([
                'id' => 'bw',
                'name' => PositionConfig::CRICKET_BOWLER,
                'shortName' => 'BW',
                'minPlayers' => 4,
                'maxPlayers' => 4,
                'minPlayersError' => 'At least %s bowlers must be selected',
                'maxPlayersError' => 'Maximum %s bowlers can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BOWLER],
            ]),
            PositionConfig::CRICKET_BATSMAN => new PositionConfig([
                'id' => 'ba',
                'name' => PositionConfig::CRICKET_BATSMAN,
                'shortName' => 'BT',
                'minPlayers' => 4,
                'maxPlayers' => 4,
                'minPlayersError' => 'At least %s batsmans must be selected',
                'maxPlayersError' => 'Maximum %s batsmans can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BATSMAN],
            ]),
            PositionConfig::CRICKET_BATTING_ALLROUNDER => new PositionConfig([
                'id' => 'bta',
                'name' => PositionConfig::CRICKET_BATTING_ALLROUNDER,
                'shortName' => 'BTA',
                'minPlayers' => 1,
                'maxPlayers' => 1,
                'minPlayersError' => 'At least %s Batting Allrounders must be selected',
                'maxPlayersError' => 'Maximum %s Batting Allrounders can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BATTING_ALLROUNDER],
            ]),
            PositionConfig::CRICKET_BOWLING_ALLROUNDER => new PositionConfig([
                'id' => 'bwa',
                'name' => PositionConfig::CRICKET_BOWLING_ALLROUNDER,
                'shortName' => 'BA',
                'minPlayers' => 1,
                'maxPlayers' => 1,
                'minPlayersError' => 'At least %s Bowling Allrounders must be selected',
                'maxPlayersError' => 'Maximum %s Bowling Allrounders can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BOWLING_ALLROUNDER],
            ]),
            PositionConfig::CRICKET_WICKETKEEPER_BATSMAN => new PositionConfig([
                'id' => 'wi',
                'name' => PositionConfig::CRICKET_WICKETKEEPER_BATSMAN,
                'shortName' => 'WB',
                'minPlayers' => 1,
                'maxPlayers' => 1,
                'minPlayersError' => 'At least %s Wicketkeeper Batsmans must be selected',
                'maxPlayersError' => 'Maximum %s Wicketkeeper Batsmans can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_WICKETKEEPER_BATSMAN],
            ]),
        ];
    }
}
