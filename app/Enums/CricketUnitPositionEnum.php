<?php

namespace App\Enums;

enum CricketUnitPositionEnum: string
{
    case bowler = 'Bowler';

    case batsman = 'Batsman';

    case battingAllrounder = 'Batting Allrounder';

    case wicketkeeperBatsman = 'Wicketkeeper batsman';

    case bowlingAllrounder = 'Bowling Allrounder';
}
