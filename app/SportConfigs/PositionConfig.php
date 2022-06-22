<?php

namespace App\SportConfigs;

class PositionConfig
{
    public const SOCCER_GOALKEEPER = 'Goalkeeper';
    public const SOCCER_FORWARD = 'Forward';
    public const SOCCER_MIDFIELD = 'Midfield';
    public const SOCCER_DEFENDER = 'Defender';

    public const CRICKET_BOWLER = 'Bowler';
    public const CRICKET_BATSMAN = 'Batsman';
    public const CRICKET_BATTING_ALLROUNDER = 'Batting Allrounder';
    public const CRICKET_WICKETKEEPER_BATSMAN = 'Wicketkeeper batsman';
    public const CRICKET_BOWLING_ALLROUNDER = 'Bowling Allrounder';

    /**
     * For internal use as css class etc.
     */
    public string $id;

    /**
     * Position title.
     */
    public string $name;

    /**
     * Position abbreviation.
     */
    public string $shortName;

    /**
     * Minimum number of players for this position.
     */
    public int $minPlayers;

    /**
     * Maximum number of players for this position.
     */
    public int $maxPlayers;

    public string $minPlayersError;

    public string $maxPlayersError;

    /**
     * Sometimes player can be picked for multiple positions
     * For example, in NBA there can be Guard, Center, Forward, Util positions. Guard player can be picked
     * as Guard or Util.
     */
    public array $allowedPositions = [];

    public function __construct(array $config = [])
    {
        foreach ($config as $property => $value) {
            $this->{$property} = $value;
        }
    }
}
