<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="BalanceResource",
 *     @OA\Property(property="balance", type="number", format="double", example="100.23")
 * )
 */
class BalanceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'balance' => (float) $this->balance,
        ];
    }
}
