<?php

namespace App\Models;

use App\Events\CricketTeamSavedEvent;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CricketTeamFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CricketTeam.
 *
 * @property int                        $id
 * @property string                     $feed_id
 * @property int                        $league_id
 * @property string                     $name
 * @property string                     $nickname
 * @property string                     $alias
 * @property int                        $country_id
 * @property null|string                $logo
 * @property string                     $feed_type
 * @property null|Carbon                $created_at
 * @property null|Carbon                $updated_at
 * @property Collection|CricketPlayer[] $cricketPlayers
 * @property null|int                   $cricket_players_count
 * @property League                     $league
 * @property Collection|CricketUnit[]   $cricketUnits
 * @property null|int                   $cricket_units_count
 *
 * @method static CricketTeamFactory factory(...$parameters)
 * @method static Builder|CricketTeam whereAlias($value)
 * @method static Builder|CricketTeam whereCountryId($value)
 * @method static Builder|CricketTeam whereCreatedAt($value)
 * @method static Builder|CricketTeam whereFeedId($value)
 * @method static Builder|CricketTeam whereFeedType($value)
 * @method static Builder|CricketTeam whereId($value)
 * @method static Builder|CricketTeam whereLeagueId($value)
 * @method static Builder|CricketTeam whereLogo($value)
 * @method static Builder|CricketTeam whereName($value)
 * @method static Builder|CricketTeam whereNickname($value)
 * @method static Builder|CricketTeam whereUpdatedAt($value)
 * @method static Builder|CricketTeam newModelQuery()
 * @method static Builder|CricketTeam newQuery()
 * @method static Builder|CricketTeam query()
 * @mixin Eloquent
 */
class CricketTeam extends Model
{
    use HasFactory;

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

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function cricketUnits(): HasMany
    {
        return $this->hasMany(CricketUnit::class);
    }
}
