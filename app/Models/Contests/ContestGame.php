<?php

namespace App\Models\Contests;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Contests\ContestGame.
 *
 * @property int                      $contest_id
 * @property int                      $game_schedule_id
 * @property int                      $sport_id            1 - Soccer; 2 - Football, 3 - Cricket
 * @property Contest                  $contest
 * @property null|CricketGameSchedule $cricketGameSchedule
 *
 * @method static Builder|ContestGame newModelQuery()
 * @method static Builder|ContestGame newQuery()
 * @method static Builder|ContestGame query()
 * @method static Builder|ContestGame whereContestId($value)
 * @method static Builder|ContestGame whereGameId($value)
 * @method static Builder|ContestGame whereSportId($value)
 * @mixin Eloquent
 */
class ContestGame extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'contest_game';

    protected $fillable = [
        'contest_id',
        'game_schedule_id',
        'sport_id',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function cricketGameSchedule(): BelongsTo
    {
        return $this->belongsTo(
            CricketGameSchedule::class,
            'game_schedule_id',
        );
    }

    public function isSportSoccer(): bool
    {
        return $this->sport_id == SportIdEnum::soccer->value;
    }

    public function isSportCricket(): bool
    {
        return $this->sport_id == SportIdEnum::cricket->value;
    }
}
