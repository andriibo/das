<?php

namespace App\Models\Soccer;

use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Soccer\SoccerTeam.
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
 * @property League $league
 *
 * @method static Builder|SoccerTeam newModelQuery()
 * @method static Builder|SoccerTeam newQuery()
 * @method static Builder|SoccerTeam query()
 * @method static Builder|SoccerTeam whereAlias($value)
 * @method static Builder|SoccerTeam whereCountryId($value)
 * @method static Builder|SoccerTeam whereFeedId($value)
 * @method static Builder|SoccerTeam whereFeedType($value)
 * @method static Builder|SoccerTeam whereId($value)
 * @method static Builder|SoccerTeam whereLeagueId($value)
 * @method static Builder|SoccerTeam whereLogoId($value)
 * @method static Builder|SoccerTeam whereName($value)
 * @method static Builder|SoccerTeam whereNickname($value)
 * @mixin Eloquent
 */
class SoccerTeam extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'soccer_team';

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

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
}
