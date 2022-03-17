<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CricketTeam.
 *
 * @property int    $id
 * @property string $feed_id
 * @property int    $league_id
 * @property string $name
 * @property string $nickname
 * @property string $alias
 * @property int    $country_id
 * @property int    $logo_id
 * @property string $feed_type
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereFeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereFeedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereLeagueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereLogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CricketTeam query()
 * @mixin \Eloquent
 */
class CricketTeam extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cricket_team';

    protected $fillable = [
        'feed_id',
        'league_id',
        'name',
        'nickname',
        'alias',
        'country_id',
        'logo_id',
        'feed_type',
    ];
}
