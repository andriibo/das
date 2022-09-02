<?php

namespace App\Mappers\Pusher;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Pusher\Dto\UserBalanceDto;

class UserBalanceMapper
{
    public function map(Authenticatable|User $user): UserBalanceDto
    {
        $userBalanceDto = new UserBalanceDto();

        $userBalanceDto->balance = $user->balance;

        return $userBalanceDto;
    }
}
