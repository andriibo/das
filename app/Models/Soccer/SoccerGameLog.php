<?php

namespace App\Models\Soccer;

use App\Models\ActionPoint;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Soccer\SoccerGameLog.
 *
 * @property int                $id
 * @property int                $game_id
 * @property int                $unit_id
 * @property int                $action_point_id
 * @property string             $value
 * @property null|Carbon        $created_at
 * @property null|Carbon        $updated_at
 * @property ActionPoint        $actionPoint
 * @property SoccerGameSchedule $gameSchedule
 * @property SoccerUnit         $unit
 *
 * @method static Builder|SoccerGameLog newModelQuery()
 * @method static Builder|SoccerGameLog newQuery()
 * @method static Builder|SoccerGameLog query()
 * @method static Builder|SoccerGameLog whereActionPointId($value)
 * @method static Builder|SoccerGameLog whereCreatedAt($value)
 * @method static Builder|SoccerGameLog whereGameId($value)
 * @method static Builder|SoccerGameLog whereId($value)
 * @method static Builder|SoccerGameLog whereUnitId($value)
 * @method static Builder|SoccerGameLog whereUpdatedAt($value)
 * @method static Builder|SoccerGameLog whereValue($value)
 * @mixin Eloquent
 */
class SoccerGameLog extends Model
{
    use HasFactory;

    protected $table = 'soccer_game_log';

    protected $fillable = [
        'game_id',
        'unit_id',
        'action_id',
        'value',
    ];

    public function gameSchedule(): BelongsTo
    {
        return $this->belongsTo(SoccerGameSchedule::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(SoccerUnit::class);
    }

    public function actionPoint(): BelongsTo
    {
        return $this->belongsTo(ActionPoint::class, 'action_id');
    }
}
