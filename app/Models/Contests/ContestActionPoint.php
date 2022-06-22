<?php

namespace App\Models\Contests;

use App\Models\ActionPoint;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Contests\ContestActionPoint.
 *
 * @property int         $contest_id
 * @property int         $action_points_id
 * @property string      $values
 * @property ActionPoint $actionPoint
 * @property Contest     $contest
 *
 * @method static Builder|ContestActionPoint newModelQuery()
 * @method static Builder|ContestActionPoint newQuery()
 * @method static Builder|ContestActionPoint query()
 * @method static Builder|ContestActionPoint whereActionPointsId($value)
 * @method static Builder|ContestActionPoint whereContestId($value)
 * @method static Builder|ContestActionPoint whereValues($value)
 * @mixin Eloquent
 */
class ContestActionPoint extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'contest_action_points';

    protected $fillable = [
        'contest_id',
        'action_points_id',
        'values',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function actionPoint(): BelongsTo
    {
        return $this->belongsTo(ActionPoint::class, 'action_points_id');
    }
}
