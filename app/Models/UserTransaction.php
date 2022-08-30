<?php

namespace App\Models;

use App\Enums\UserTransactions\TypeEnum;
use App\Events\UserTransactionCreatedEvent;
use App\Models\Contests\ContestUser;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserTransaction.
 *
 * @property int                  $id
 * @property int                  $user_id
 * @property null|int             $subject_id
 * @property null|int             $parent_id
 * @property int                  $type        1 - TYPE_DEPOSIT; 2 - TYPE_WITHDRAW; 3 - TYPE_CONTEST_ENTER; 4 - TYPE_CONTEST_WIN; 5 - TYPE_CONTEST_CANCEL; 6 - TYPE_CONTEST_LEAVE; 7 - TYPE_PROMO_CODE; 8 - TYPE_THRESHOLD; 9 - TYPE_DEPOSIT_BONUS; 11 - TYPE_ACTIVATION_BONUS; 12 - TYPE_DAILY_BONUS
 * @property int                  $status      0 - STATUS_NEW; 1 - STATUS_SUCCESS; 2 - STATUS_DECLINED; 3 - STATUS_CANCELLED; 4 - STATUS_RETURNED_BONUS
 * @property string               $amount
 * @property null|string          $note
 * @property string               $created_at
 * @property string               $updated_at
 * @property null|ContestUser     $contestUser
 * @property User                 $user
 * @property null|UserTransaction $parent
 *
 * @method static Builder|UserTransaction newModelQuery()
 * @method static Builder|UserTransaction newQuery()
 * @method static Builder|UserTransaction query()
 * @method static Builder|UserTransaction whereAmount($value)
 * @method static Builder|UserTransaction whereCreatedAt($value)
 * @method static Builder|UserTransaction whereId($value)
 * @method static Builder|UserTransaction whereNote($value)
 * @method static Builder|UserTransaction whereParentId($value)
 * @method static Builder|UserTransaction whereStatus($value)
 * @method static Builder|UserTransaction whereSubjectId($value)
 * @method static Builder|UserTransaction whereType($value)
 * @method static Builder|UserTransaction whereUpdatedAt($value)
 * @method static Builder|UserTransaction whereUserId($value)
 * @mixin Eloquent
 */
class UserTransaction extends Model
{
    use HasFactory;

    protected $table = 'user_transaction';

    protected $dispatchesEvents = [
        'created' => UserTransactionCreatedEvent::class,
    ];

    protected $fillable = [
        'user_id',
        'subject_id',
        'parent_id',
        'type',
        'status',
        'amount',
        'note',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contestUser(): BelongsTo
    {
        return $this->belongsTo(ContestUser::class, 'subject_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function isTypeWithdraw(): bool
    {
        return $this->type == TypeEnum::withdraw->value;
    }

    public function isTypeContestEnter(): bool
    {
        return $this->type == TypeEnum::contestEnter->value;
    }
}
