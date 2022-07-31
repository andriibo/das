<?php

namespace App\Models\Contests;

use App\Models\User;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Contests\ContestUser.
 *
 * @property int                      $id
 * @property int                      $contest_id
 * @property int                      $user_id
 * @property string                   $title
 * @property string                   $team_score
 * @property int                      $place
 * @property string                   $prize
 * @property int                      $is_winner
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 * @property string                   $barcode
 * @property Contest                  $contest
 * @property User                     $user
 * @property Collection|ContestUnit[] $contestUnits
 * @property null|int                 $contest_units_count
 *
 * @method static Builder|ContestUser newModelQuery()
 * @method static Builder|ContestUser newQuery()
 * @method static Builder|ContestUser query()
 * @method static Builder|ContestUser whereBarcode($value)
 * @method static Builder|ContestUser whereContestId($value)
 * @method static Builder|ContestUser whereCreatedAt($value)
 * @method static Builder|ContestUser whereId($value)
 * @method static Builder|ContestUser whereIsWinner($value)
 * @method static Builder|ContestUser wherePlace($value)
 * @method static Builder|ContestUser wherePrize($value)
 * @method static Builder|ContestUser whereTeamScore($value)
 * @method static Builder|ContestUser whereTitle($value)
 * @method static Builder|ContestUser whereUpdatedAt($value)
 * @method static Builder|ContestUser whereUserId($value)
 * @mixin Eloquent
 */
class ContestUser extends Model
{
    use HasFactory;

    protected $table = 'contest_user';

    protected $fillable = [
        'contest_id',
        'user_id',
        'title',
        'team_score',
        'place',
        'prize',
        'is_winner',
        'barcode',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contestUnits(): BelongsToMany
    {
        return $this->belongsToMany(
            ContestUnit::class,
            (new ContestUserUnit())->getTable(),
            'contest_user_id',
            'contest_unit_id'
        );
    }
}
