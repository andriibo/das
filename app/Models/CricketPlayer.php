<?php

namespace App\Models;

use App\Events\CricketPlayerSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketPlayerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketPlayer.
 *
 * @property int                      $id
 * @property string                   $feed_type
 * @property string                   $feed_id
 * @property string                   $sport
 * @property string                   $first_name
 * @property string                   $last_name
 * @property null|string              $photo
 * @property string                   $injury_status
 * @property null|string              $salary
 * @property null|string              $auto_salary
 * @property null|string              $total_fantasy_points
 * @property null|string              $total_fantasy_points_per_game
 * @property null|Carbon              $created_at
 * @property null|Carbon              $updated_at
 * @property Collection|CricketUnit[] $cricketUnits
 * @property null|int                 $cricket_units_count
 *
 * @method static CricketPlayerFactory factory(...$parameters)
 * @method static Builder|CricketPlayer newModelQuery()
 * @method static Builder|CricketPlayer newQuery()
 * @method static Builder|CricketPlayer query()
 * @method static Builder|CricketPlayer whereAutoSalary($value)
 * @method static Builder|CricketPlayer whereCreatedAt($value)
 * @method static Builder|CricketPlayer whereFeedId($value)
 * @method static Builder|CricketPlayer whereFeedType($value)
 * @method static Builder|CricketPlayer whereFirstName($value)
 * @method static Builder|CricketPlayer whereId($value)
 * @method static Builder|CricketPlayer whereInjuryStatus($value)
 * @method static Builder|CricketPlayer whereLastName($value)
 * @method static Builder|CricketPlayer wherePhoto($value)
 * @method static Builder|CricketPlayer whereSalary($value)
 * @method static Builder|CricketPlayer whereSport($value)
 * @method static Builder|CricketPlayer whereTotalFantasyPoints($value)
 * @method static Builder|CricketPlayer whereTotalFantasyPointsPerGame($value)
 * @method static Builder|CricketPlayer whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketPlayer extends Model
{
    use HasFactory;

    protected $table = 'cricket_player';

    protected $fillable = [
        'feed_type',
        'feed_id',
        'sport',
        'first_name',
        'last_name',
        'photo',
        'injury_status',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];

    protected $dispatchesEvents = ['saved' => CricketPlayerSavedEvent::class];

    public function cricketUnits(): HasMany
    {
        return $this->hasMany(CricketUnit::class);
    }
}
