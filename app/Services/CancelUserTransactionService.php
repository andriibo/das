<?php

namespace App\Services;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Exceptions\CancelUserTransactionServiceException;
use App\Exceptions\UpdateBalanceServiceException;
use App\Models\UserTransaction;
use App\Repositories\UserTransactionRepository;

class CancelUserTransactionService
{
    public function __construct(
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly UpdateBalanceService $updateBalanceService
    ) {
    }

    /* @throws UpdateBalanceServiceException|CancelUserTransactionServiceException */
    public function handle(UserTransaction $userTransaction): bool
    {
        if ($userTransaction->status === StatusEnum::cancelled->value) {
            return true;
        }

        $isStatusUpdated = $this->userTransactionRepository->updateStatus($userTransaction, StatusEnum::cancelled);

        if (!$isStatusUpdated) {
            return false;
        }

        return match ($userTransaction->type) {
            TypeEnum::contestWin->value => $this->updateBalanceService->updateBalance($userTransaction->user, -$userTransaction->amount),
            TypeEnum::withdraw->value => $this->updateBalanceService->updateBalance($userTransaction->user, $userTransaction->amount),
            default => throw new CancelUserTransactionServiceException('Not implemented for ' . $userTransaction->type),
        };
    }
}
