<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\League.
 *
 * @property int        $id
 * @property string     $alias
 * @property string     $name
 * @property string     $season
 * @property int        $sport_id
 * @property int        $is_enabled
 * @property string     $date_updated
 * @property int        $order
 * @property int        $config_id
 * @property null|array $params
 * @property null|int   $recently_enabled
 *
 * @method static \Illuminate\Database\Eloquent\Builder|League whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereConfigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereDateUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereRecentlyEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereSeason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|League newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|League newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|League query()
 * @mixin \Eloquent
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
}
