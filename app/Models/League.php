<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\League.
 *
 * @property int                      $id
 * @property string                   $alias
 * @property string                   $name
 * @property string                   $season
 * @property int                      $sport_id
 * @property int                      $is_enabled
 * @property string                   $date_updated
 * @property int                      $order
 * @property int                      $config_id
 * @property null|array               $params
 * @property null|int                 $recently_enabled
 * @property Collection|CricketTeam[] $cricketTeams
 * @property null|int                 $cricket_teams_count
 *
 * @method static Builder|League whereAlias($value)
 * @method static Builder|League whereConfigId($value)
 * @method static Builder|League whereDateUpdated($value)
 * @method static Builder|League whereId($value)
 * @method static Builder|League whereIsEnabled($value)
 * @method static Builder|League whereName($value)
 * @method static Builder|League whereOrder($value)
 * @method static Builder|League whereParams($value)
 * @method static Builder|League whereRecentlyEnabled($value)
 * @method static Builder|League whereSeason($value)
 * @method static Builder|League whereSportId($value)
 * @method static Builder|League newModelQuery()
 * @method static Builder|League newQuery()
 * @method static Builder|League query()
 * @mixin Eloquent
 */
class League extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'league';

    protected $casts = [
        'params' => 'array',
    ];

    protected $fillable = [
        'alias',
        'name',
        'season',
        'sport_id',
        'is_enabled',
        'date_updated',
        'order',
        'config_id',
        'params',
        'recently_enabled',
    ];

    public function cricketTeams(): HasMany
    {
        return $this->hasMany(CricketTeam::class, 'league_id');
    }
}
