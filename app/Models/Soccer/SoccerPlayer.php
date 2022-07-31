<?php

namespace App\Models\Soccer;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Soccer\SoccerPlayer.
 *
 * @property int         $id
 * @property string      $feed_type
 * @property string      $feed_id
 * @property int         $sport_id
 * @property string      $first_name
 * @property string      $last_name
 * @property null|string $photo
 * @property string      $injury_status
 * @property null|string $salary
 * @property null|string $auto_salary
 * @property null|string $total_fantasy_points
 * @property null|string $total_fantasy_points_per_game
 *
 * @method static Builder|SoccerPlayer newModelQuery()
 * @method static Builder|SoccerPlayer newQuery()
 * @method static Builder|SoccerPlayer query()
 * @method static Builder|SoccerPlayer whereAutoSalary($value)
 * @method static Builder|SoccerPlayer whereFeedId($value)
 * @method static Builder|SoccerPlayer whereFeedType($value)
 * @method static Builder|SoccerPlayer whereFirstName($value)
 * @method static Builder|SoccerPlayer whereId($value)
 * @method static Builder|SoccerPlayer whereInjuryStatus($value)
 * @method static Builder|SoccerPlayer whereLastName($value)
 * @method static Builder|SoccerPlayer wherePhoto($value)
 * @method static Builder|SoccerPlayer whereSalary($value)
 * @method static Builder|SoccerPlayer whereSportId($value)
 * @method static Builder|SoccerPlayer whereTotalFantasyPoints($value)
 * @method static Builder|SoccerPlayer whereTotalFantasyPointsPerGame($value)
 * @mixin Eloquent
 */
class SoccerPlayer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'player';

    protected $fillable = [
        'feed_type',
        'feed_id',
        'sport_id',
        'first_name',
        'last_name',
        'photo',
        'injury_status',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];

    public function getFullName(): string
    {
        $name = array_filter([
            $this->first_name,
            $this->last_name,
        ]);

        return implode(' ', $name);
    }
}
