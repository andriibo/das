<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CricketTeamPlayer.
 *
 * @property int           $id
 * @property int           $cricket_team_id
 * @property int           $cricket_player_id
 * @property string        $playing_role
 * @property CricketPlayer $cricketPlayer
 * @property CricketTeam   $cricketTeam
 *
 * @method static Builder|CricketTeamPlayer newModelQuery()
 * @method static Builder|CricketTeamPlayer newQuery()
 * @method static Builder|CricketTeamPlayer query()
 * @method static Builder|CricketTeamPlayer whereCricketPlayerId($value)
 * @method static Builder|CricketTeamPlayer whereCricketTeamId($value)
 * @method static Builder|CricketTeamPlayer whereId($value)
 * @method static Builder|CricketTeamPlayer wherePlayingRole($value)
 * @mixin Eloquent
 */
class CricketTeamPlayer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cricket_team_player';

    protected $fillable = [
        'cricket_team_id',
        'cricket_player_id',
        'playing_role',
    ];

    public function cricketTeam(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class);
    }

    public function cricketPlayer(): BelongsTo
    {
        return $this->belongsTo(CricketPlayer::class);
    }
}
