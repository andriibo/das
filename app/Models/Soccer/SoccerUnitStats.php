<?php

namespace App\Models\Soccer;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Soccer\SoccerUnitStats.
 *
 * @property int                     $id
 * @property null|int                $game_id
 * @property int                     $unit_id
 * @property null|int                $team_id
 * @property string                  $stats
 * @property string                  $raw_stats
 * @property Carbon                  $created_at
 * @property Carbon                  $updated_at
 * @property null|SoccerGameSchedule $gameSchedule
 * @property null|SoccerTeam         $team
 * @property SoccerUnit              $unit
 *
 * @method static Builder|SoccerUnitStats newModelQuery()
 * @method static Builder|SoccerUnitStats newQuery()
 * @method static Builder|SoccerUnitStats query()
 * @method static Builder|SoccerUnitStats whereCreatedAt($value)
 * @method static Builder|SoccerUnitStats whereGameId($value)
 * @method static Builder|SoccerUnitStats whereId($value)
 * @method static Builder|SoccerUnitStats whereRawStats($value)
 * @method static Builder|SoccerUnitStats whereStats($value)
 * @method static Builder|SoccerUnitStats whereTeamId($value)
 * @method static Builder|SoccerUnitStats whereUnitId($value)
 * @method static Builder|SoccerUnitStats whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SoccerUnitStats extends Model
{
    use HasFactory;

    protected $table = 'soccer_unit_stats';

    protected $fillable = [
        'game_id',
        'unit_id',
        'team_id',
        'stats',
        'raw_stats',
    ];

    protected $casts = [
        'stats' => 'array',
        'raw_stats' => 'array',
    ];

    public function gameSchedule(): BelongsTo
    {
        return $this->belongsTo(SoccerGameSchedule::class, 'game_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(SoccerUnit::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(SoccerTeam::class);
    }
}
