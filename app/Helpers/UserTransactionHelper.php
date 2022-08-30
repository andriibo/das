<?php

namespace App\Helpers;

use App\Models\UserTransaction;

class UserTransactionHelper
{
    public static function getAmount(UserTransaction $userTransaction): float
    {
        return ($userTransaction->isTypeWithdraw() || $userTransaction->isTypeContestEnter())
            ? -$userTransaction->amount
            : $userTransaction->amount;
    }
}
