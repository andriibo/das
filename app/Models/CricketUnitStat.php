<?php

namespace App\Models;

use App\Events\CricketGameScheduleSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketUnitStat.
 *
 * @property int                 $id
 * @property int                 $cricket_game_schedule_id
 * @property int                 $cricket_player_id
 * @property int                 $cricket_team_id
 * @property string              $stats
 * @property string              $date_updated
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property CricketGameSchedule $cricketGameSchedule
 * @property CricketPlayer       $cricketPlayer
 * @property CricketTeam         $cricketTeam
 *
 * @method static Builder|CricketUnitStat newModelQuery()
 * @method static Builder|CricketUnitStat newQuery()
 * @method static Builder|CricketUnitStat query()
 * @method static Builder|CricketUnitStat whereCreatedAt($value)
 * @method static Builder|CricketUnitStat whereCricketGameScheduleId($value)
 * @method static Builder|CricketUnitStat whereCricketPlayerId($value)
 * @method static Builder|CricketUnitStat whereCricketTeamId($value)
 * @method static Builder|CricketUnitStat whereDateUpdated($value)
 * @method static Builder|CricketUnitStat whereId($value)
 * @method static Builder|CricketUnitStat whereStats($value)
 * @method static Builder|CricketUnitStat whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketUnitStat extends Model
{
    use HasFactory;

    protected $table = 'cricket_unit_stat';

    protected $fillable = [
        'cricket_game_schedule_id',
        'cricket_player_id',
        'cricket_team_id',
        'stats',
        'date_updated',
    ];

    protected $dispatchesEvents = ['saved' => CricketGameScheduleSavedEvent::class];

    public function cricketGameSchedule(): BelongsTo
    {
        return $this->belongsTo(CricketGameSchedule::class);
    }

    public function cricketPlayer(): BelongsTo
    {
        return $this->belongsTo(CricketPlayer::class);
    }

    public function cricketTeam(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class);
    }
}
