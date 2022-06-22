<?php

namespace App\Models\Contests;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Contests\ContestUserUnit.
 *
 * @property int         $id
 * @property int         $contest_user_id
 * @property int         $contest_unit_id
 * @property int         $order
 * @property string      $position
 * @property ContestUnit $contestUnit
 * @property ContestUser $contestUser
 *
 * @method static Builder|ContestUserUnit newModelQuery()
 * @method static Builder|ContestUserUnit newQuery()
 * @method static Builder|ContestUserUnit query()
 * @method static Builder|ContestUserUnit whereContestUnitId($value)
 * @method static Builder|ContestUserUnit whereContestUserId($value)
 * @method static Builder|ContestUserUnit whereId($value)
 * @method static Builder|ContestUserUnit whereOrder($value)
 * @method static Builder|ContestUserUnit wherePosition($value)
 * @mixin Eloquent
 */
class ContestUserUnit extends Model
{
    public $timestamps = false;

    protected $table = 'contest_user_unit';

    protected $fillable = [
        'contest_user_id',
        'contest_unit_id',
        'order',
        'position',
    ];

    public function contestUser(): BelongsTo
    {
        return $this->belongsTo(ContestUser::class);
    }

    public function contestUnit(): BelongsTo
    {
        return $this->belongsTo(ContestUnit::class);
    }
}
