<?php

namespace App\Enums\UserTransactions;

use ArchTech\Enums\Values;

enum TypeEnum: int
{
    use Values;

    case deposit = 1;

    case withdraw = 2;

    case contestEnter = 3;

    case contestWin = 4;

    case contestCancel = 5;

    case contestLeave = 6;

    case promoCode = 7;

    case threshold = 8;

    case depositBonus = 9;

    case activationBonus = 11;

    case dailyBonus = 12;
}
