<?php

namespace App\Repositories;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Models\Contests\ContestUser;
use App\Models\UserTransaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserTransactionRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $userTransactionId): UserTransaction
    {
        return UserTransaction::findOrFail($userTransactionId);
    }

    public function create(array $attributes): UserTransaction
    {
        return UserTransaction::query()->create($attributes);
    }

    public function getContestWinTransactionByUserIdAndSubjectId(int $userId, int $subjectId): ?UserTransaction
    {
        return UserTransaction::query()
            ->where('user_id', $userId)
            ->where('type', TypeEnum::contestWin->value)
            ->where('status', StatusEnum::success->value)
            ->where('subject_id', $subjectId)
            ->first()
            ;
    }

    public function updateStatus(UserTransaction $userTransaction, StatusEnum $status): bool
    {
        return $userTransaction->update(['status' => $status->value]);
    }

    public function createWinTransactionByContestUser(ContestUser $contestUser): UserTransaction
    {
        return UserTransaction::query()->create([
            'type' => TypeEnum::contestWin->value,
            'subject_id' => $contestUser->id,
            'user_id' => $contestUser->user_id,
            'status' => StatusEnum::success->value,
            'amount' => $contestUser->prize,
        ]);
    }
}
