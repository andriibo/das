<?php

namespace App\Models;

use App\Events\CricketUnitStatSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketGameStatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketUnitStat.
 *
 * @property int                 $id
 * @property int                 $game_schedule_id
 * @property int                 $player_id
 * @property int                 $team_id
 * @property mixed               $raw_stat
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property CricketGameSchedule $gameSchedule
 * @property CricketPlayer       $player
 * @property CricketTeam         $team
 *
 * @method static CricketGameStatFactory factory(...$parameters)
 * @method static Builder|CricketUnitStat newModelQuery()
 * @method static Builder|CricketUnitStat newQuery()
 * @method static Builder|CricketUnitStat query()
 * @method static Builder|CricketUnitStat whereCreatedAt($value)
 * @method static Builder|CricketUnitStat whereGameScheduleId($value)
 * @method static Builder|CricketUnitStat whereId($value)
 * @method static Builder|CricketUnitStat wherePlayerId($value)
 * @method static Builder|CricketUnitStat whereRawStat($value)
 * @method static Builder|CricketUnitStat whereTeamId($value)
 * @method static Builder|CricketUnitStat whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketUnitStat extends Model
{
    use HasFactory;

    protected $table = 'cricket_unit_stat';

    protected $casts = [
        'raw_stat' => 'array',
    ];

    protected $fillable = [
        'game_schedule_id',
        'player_id',
        'team_id',
        'raw_stat',
    ];

    protected $dispatchesEvents = ['saved' => CricketUnitStatSavedEvent::class];

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
