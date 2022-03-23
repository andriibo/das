<?php

namespace App\Models;

use App\Events\CricketTeamSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\CricketTeam.
 *
 * @property int                                                      $id
 * @property string                                                   $feed_id
 * @property int                                                      $league_id
 * @property string                                                   $name
 * @property string                                                   $nickname
 * @property string                                                   $alias
 * @property int                                                      $country_id
 * @property null|string                                              $logo
 * @property string                                                   $feed_type
 * @property CricketPlayer[]|\Illuminate\Database\Eloquent\Collection $cricketPlayers
 * @property null|int                                                 $cricket_players_count
 *
 * @method static Builder|CricketTeam whereAlias($value)
 * @method static Builder|CricketTeam whereCountryId($value)
 * @method static Builder|CricketTeam whereFeedId($value)
 * @method static Builder|CricketTeam whereFeedType($value)
 * @method static Builder|CricketTeam whereId($value)
 * @method static Builder|CricketTeam whereLeagueId($value)
 * @method static Builder|CricketTeam whereLogo($value)
 * @method static Builder|CricketTeam whereName($value)
 * @method static Builder|CricketTeam whereNickname($value)
 * @method static Builder|CricketTeam newModelQuery()
 * @method static Builder|CricketTeam newQuery()
 * @method static Builder|CricketTeam query()
 * @mixin Eloquent
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
        'logo',
        'feed_type',
    ];

    protected $dispatchesEvents = ['saved' => CricketTeamSavedEvent::class];

    public function cricketPlayers(): BelongsToMany
    {
        return $this->belongsToMany(CricketPlayer::class, 'cricket_team_player');
    }
}
