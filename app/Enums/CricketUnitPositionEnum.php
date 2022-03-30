<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum CricketUnitPositionEnum: string
{
    use Values;

    case bowler = 'Bowler';

    case batsman = 'Batsman';

    case battingAllrounder = 'Batting Allrounder';

    case wicketkeeperBatsman = 'Wicketkeeper batsman';

    case bowlingAllrounder = 'Bowling Allrounder';
}
