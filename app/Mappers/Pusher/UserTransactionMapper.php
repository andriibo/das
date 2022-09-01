<?php

namespace App\Mappers\Pusher;

use App\Helpers\DateHelper;
use App\Helpers\UserTransactionHelper;
use App\Models\UserTransaction;
use Pusher\Dto\UserTransactionDto;

class UserTransactionMapper
{
    public function map(UserTransaction $userTransaction): UserTransactionDto
    {
        $userTransactionDto = new UserTransactionDto();

        $userTransactionDto->id = $userTransaction->id;
        $userTransactionDto->amount = UserTransactionHelper::getAmount($userTransaction);
        $userTransactionDto->status = $userTransaction->status;
        $userTransactionDto->createdAt = DateHelper::dateFormatMs($userTransaction->created_at);
        $userTransactionDto->updatedAt = DateHelper::dateFormatMs($userTransaction->created_at);

        return $userTransactionDto;
    }
}
