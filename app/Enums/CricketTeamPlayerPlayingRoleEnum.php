<?php

namespace App\Enums;

enum CricketTeamPlayerPlayingRoleEnum: string
{
    case bowler = 'Bowler';

    case batsman = 'Batsman';

    case topOrderBatsman = 'Top-order batsman';

    case middleOrderBatsman = 'Middle-order batsman';

    case openingBatsman = 'Opening batsman';

    case allrounder = 'Allrounder';

    case battingAllrounder = 'Batting Allrounder';

    case wicketkeeper = 'Wicketkeeper';

    case wicketkeeperBatsman = 'Wicketkeeper batsman';

    case bowlingAllrounder = 'Bowling Allrounder';
}
