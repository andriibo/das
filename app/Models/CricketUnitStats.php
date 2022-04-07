<?php

namespace App\Models;

use App\Events\CricketUnitStatsSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketGameStatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketUnitStats.
 *
 * @property int                 $id
 * @property int                 $game_schedule_id
 * @property int                 $player_id
 * @property int                 $team_id
 * @property mixed               $raw_stats
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property CricketGameSchedule $gameSchedule
 * @property CricketPlayer       $player
 * @property CricketTeam         $team
 *
 * @method static CricketGameStatFactory factory(...$parameters)
 * @method static Builder|CricketUnitStats newModelQuery()
 * @method static Builder|CricketUnitStats newQuery()
 * @method static Builder|CricketUnitStats query()
 * @method static Builder|CricketUnitStats whereCreatedAt($value)
 * @method static Builder|CricketUnitStats whereGameScheduleId($value)
 * @method static Builder|CricketUnitStats whereId($value)
 * @method static Builder|CricketUnitStats wherePlayerId($value)
 * @method static Builder|CricketUnitStats whereRawStat($value)
 * @method static Builder|CricketUnitStats whereTeamId($value)
 * @method static Builder|CricketUnitStats whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketUnitStats extends Model
{
    use HasFactory;

    protected $table = 'cricket_unit_stats';

    protected $casts = [
        'raw_stats' => 'array',
    ];

    protected $fillable = [
        'game_schedule_id',
        'player_id',
        'team_id',
        'raw_stats',
    ];

    protected $dispatchesEvents = ['saved' => CricketUnitStatsSavedEvent::class];

    public function gameSchedule(): BelongsTo
    {
        return $this->belongsTo(CricketGameSchedule::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(CricketPlayer::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class);
    }
}
