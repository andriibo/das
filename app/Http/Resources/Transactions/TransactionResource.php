<?php

namespace App\Http\Resources\Transactions;

use App\Helpers\DateHelper;
use App\Helpers\UserTransactionHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TransactionResource",
 *     @OA\Property(property="id", type="integer", example="12"),
 *     @OA\Property(property="amount", type="number", format="double", example="230.41"),
 *     @OA\Property(property="status", type="integer", enum={0,1,2,3,4,5}, description="0 - New, 1 - Success, 2 - Declined, 3 - Cancelled, 4 - Returned, 5 - Approved"),
 *     @OA\Property(property="type", type="integer", enum={1,2,3,4,5,6,7,8,9,11,12}, description="1 - Deposit, 2 - Withdraw, 3 - Enter Contest, 4 - Win Contest, 5 - Contest Cancelled, 6 - Leave Contest, 7 - Promo Code, 8 - Threshold, 9 - Deposit Bonus, 11 - Activation Bonus, 12 - Daily Bonus"),
 *     @OA\Property(property="createdAt", type="integer", example="1650112441000"),
 *     @OA\Property(property="updatedAt", type="integer", example="1650112441000")
 * )
 */
class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => UserTransactionHelper::getAmount($this->resource),
            'status' => $this->status,
            'type' => $this->type,
            'createdAt' => DateHelper::dateFormatMs($this->created_at),
            'updatedAt' => DateHelper::dateFormatMs($this->updated_at),
        ];
    }
}
