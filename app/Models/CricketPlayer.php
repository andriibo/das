<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CricketPlayer.
 *
 * @property int         $id
 * @property string      $feed_type
 * @property string      $feed_id
 * @property int         $sport_id
 * @property string      $first_name
 * @property string      $last_name
 * @property null|string $image_name
 * @property string      $injury_status
 * @property null|string $salary
 * @property null|string $auto_salary
 * @property null|string $total_fantasy_points
 * @property null|string $total_fantasy_points_per_game
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer query()
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereAutoSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereFeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereFeedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereImageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereInjuryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereTotalFantasyPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketPlayer whereTotalFantasyPointsPerGame($value)
 * @mixin Eloquent
 */
class CricketPlayer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cricket_player';

    protected $fillable = [
        'feed_type',
        'feed_id',
        'sport_id',
        'first_name',
        'last_name',
        'image_name',
        'injury_status',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];
}
