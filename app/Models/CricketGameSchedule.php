<?php

namespace App\Models;

use App\Events\CricketGameScheduleSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketGameScheduleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketGameSchedule.
 *
 * @property int         $id
 * @property string      $feed_id
 * @property int         $league_id
 * @property int         $home_team_id
 * @property int         $away_team_id
 * @property string      $game_date
 * @property int         $has_final_box
 * @property int         $is_data_confirmed
 * @property string      $home_team_score
 * @property string      $away_team_score
 * @property null|Carbon $date_updated
 * @property int         $is_fake
 * @property int         $is_salary_available
 * @property string      $feed_type
 * @property null|string $status
 * @property string      $type
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 * @property League      $league
 * @property CricketTeam $homeTeam
 * @property CricketTeam $awayCricketTeam
 *
 * @method static CricketGameScheduleFactory factory(...$parameters)
 * @method static Builder|CricketGameSchedule newModelQuery()
 * @method static Builder|CricketGameSchedule newQuery()
 * @method static Builder|CricketGameSchedule query()
 * @method static Builder|CricketGameSchedule whereAwayTeamId($value)
 * @method static Builder|CricketGameSchedule whereAwayTeamScore($value)
 * @method static Builder|CricketGameSchedule whereCreatedAt($value)
 * @method static Builder|CricketGameSchedule whereDateUpdated($value)
 * @method static Builder|CricketGameSchedule whereFeedId($value)
 * @method static Builder|CricketGameSchedule whereFeedType($value)
 * @method static Builder|CricketGameSchedule whereGameDate($value)
 * @method static Builder|CricketGameSchedule whereHasFinalBox($value)
 * @method static Builder|CricketGameSchedule whereHomeTeamId($value)
 * @method static Builder|CricketGameSchedule whereHomeTeamScore($value)
 * @method static Builder|CricketGameSchedule whereId($value)
 * @method static Builder|CricketGameSchedule whereIsDataConfirmed($value)
 * @method static Builder|CricketGameSchedule whereIsFake($value)
 * @method static Builder|CricketGameSchedule whereIsSalaryAvailable($value)
 * @method static Builder|CricketGameSchedule whereLeagueId($value)
 * @method static Builder|CricketGameSchedule whereStatus($value)
 * @method static Builder|CricketGameSchedule whereType($value)
 * @method static Builder|CricketGameSchedule whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketGameSchedule extends Model
{
    use HasFactory;

    protected $table = 'cricket_game_schedule';

    protected $fillable = [
        'feed_id',
        'league_id',
        'home_team_id',
        'away_team_id',
        'game_date',
        'has_final_box',
        'is_data_confirmed',
        'home_team_score',
        'away_team_score',
        'date_updated',
        'is_fake',
        'is_salary_available',
        'feed_type',
        'status',
        'type',
    ];

    protected $dispatchesEvents = ['saved' => CricketGameScheduleSavedEvent::class];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class);
    }
}
