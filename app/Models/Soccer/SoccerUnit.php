<?php

namespace App\Models\Soccer;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Soccer\SoccerUnit.
 *
 * @property int                          $id
 * @property int                          $unit_id
 * @property string                       $unit_type
 * @property null|string                  $position
 * @property null|string                  $salary
 * @property null|string                  $auto_salary
 * @property null|string                  $fantasy_points
 * @property null|string                  $fantasy_points_per_game
 * @property null|string                  $point_spread
 * @property null|SoccerPlayer            $player
 * @property Collection|SoccerUnitStats[] $unitStats
 * @property null|int                     $unit_stats_count
 * @property null|SoccerUnitStats         $totalUnitStats
 *
 * @method static Builder|SoccerUnit newModelQuery()
 * @method static Builder|SoccerUnit newQuery()
 * @method static Builder|SoccerUnit query()
 * @method static Builder|SoccerUnit whereAutoSalary($value)
 * @method static Builder|SoccerUnit whereFantasyPoints($value)
 * @method static Builder|SoccerUnit whereFantasyPointsPerGame($value)
 * @method static Builder|SoccerUnit whereId($value)
 * @method static Builder|SoccerUnit wherePointSpread($value)
 * @method static Builder|SoccerUnit wherePosition($value)
 * @method static Builder|SoccerUnit whereSalary($value)
 * @method static Builder|SoccerUnit whereUnitId($value)
 * @method static Builder|SoccerUnit whereUnitType($value)
 * @mixin Eloquent
 */
class SoccerUnit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'unit';

    protected $fillable = [
        'unit_id',
        'unit_type',
        'position',
        'salary',
        'auto_salary',
        'fantasy_points',
        'fantasy_points_per_game',
        'point_spread',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(SoccerPlayer::class, 'unit_id');
    }

    public function unitStats(): HasMany
    {
        return $this->hasMany(SoccerUnitStats::class, 'unit_id');
    }

    public function totalUnitStats(): ?SoccerUnitStats
    {
        return $this->unitStats->whereNull('game_id')->first();
    }
}
