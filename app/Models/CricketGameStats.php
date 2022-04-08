<?php

namespace App\Models;

use App\Events\CricketGameStatsSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketGameStatsFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketGameStats.
 *
 * @property int                 $id
 * @property int                 $game_schedule_id
 * @property string              $raw_stats
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property CricketGameSchedule $gameSchedule
 *
 * @method static CricketGameStatsFactory factory(...$parameters)
 * @method static Builder|CricketGameStats newModelQuery()
 * @method static Builder|CricketGameStats newQuery()
 * @method static Builder|CricketGameStats query()
 * @method static Builder|CricketGameStats whereCreatedAt($value)
 * @method static Builder|CricketGameStats whereGameScheduleId($value)
 * @method static Builder|CricketGameStats whereId($value)
 * @method static Builder|CricketGameStats whereRawStats($value)
 * @method static Builder|CricketGameStats whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketGameStats extends Model
{
    use HasFactory;

    protected $table = 'cricket_game_stats';

    protected $casts = [
        'raw_stats' => 'array',
    ];

    protected $fillable = [
        'game_schedule_id',
        'raw_stats',
    ];

    protected $dispatchesEvents = ['saved' => CricketGameStatsSavedEvent::class];

    public function gameSchedule(): BelongsTo
    {
        return $this->belongsTo(CricketGameSchedule::class);
    }
}
