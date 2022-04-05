<?php

namespace App\Models;

use App\Events\CricketGameStatSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketGameStatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketGameStat.
 *
 * @property int                 $id
 * @property int                 $cricket_game_schedule_id
 * @property string              $raw_stat
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property CricketGameSchedule $cricketGameSchedule
 *
 * @method static CricketGameStatFactory factory(...$parameters)
 * @method static Builder|CricketGameStat newModelQuery()
 * @method static Builder|CricketGameStat newQuery()
 * @method static Builder|CricketGameStat query()
 * @method static Builder|CricketGameStat whereCreatedAt($value)
 * @method static Builder|CricketGameStat whereCricketGameScheduleId($value)
 * @method static Builder|CricketGameStat whereId($value)
 * @method static Builder|CricketGameStat whereRawStat($value)
 * @method static Builder|CricketGameStat whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketGameStat extends Model
{
    use HasFactory;

    protected $table = 'cricket_game_stat';

    protected $casts = [
        'raw_stat' => 'array',
    ];

    protected $fillable = [
        'cricket_game_schedule_id',
        'raw_stat',
    ];

    protected $dispatchesEvents = ['saved' => CricketGameStatSavedEvent::class];

    public function cricketGameSchedule(): BelongsTo
    {
        return $this->belongsTo(CricketGameSchedule::class);
    }
}
