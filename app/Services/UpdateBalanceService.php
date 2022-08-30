<?php

namespace App\Services;

use App\Events\UserBalanceUpdatedEvent;
use App\Exceptions\UpdateBalanceServiceException;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateBalanceService
{
    /**
     * @throws UpdateBalanceServiceException
     */
    public function updateBalance(Authenticatable|User $user, float $amount): bool
    {
        if (!($user->balance + $amount) < 0) {
            throw new UpdateBalanceServiceException('Balance cannot be less than 0.');
        }

        $user->balance += $amount;

        if (!$result = $user->save()) {
            throw new UpdateBalanceServiceException('Can\'t update user balance');
        }

        event(new UserBalanceUpdatedEvent($user));

        return $result;
    }
}
