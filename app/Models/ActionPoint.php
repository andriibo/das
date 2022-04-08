<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ActionPointFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActionPoint.
 *
 * @property int         $id
 * @property string      $name
 * @property int         $sport_id
 * @property string      $values
 * @property int         $sort_order
 * @property int         $is_enabled
 * @property null|string $title
 * @property string      $alias
 * @property string      $game_log_template
 *
 * @method static ActionPointFactory factory(...$parameters)
 * @method static Builder|ActionPoint newModelQuery()
 * @method static Builder|ActionPoint newQuery()
 * @method static Builder|ActionPoint query()
 * @method static Builder|ActionPoint whereAlias($value)
 * @method static Builder|ActionPoint whereGameLogTemplate($value)
 * @method static Builder|ActionPoint whereId($value)
 * @method static Builder|ActionPoint whereIsEnabled($value)
 * @method static Builder|ActionPoint whereName($value)
 * @method static Builder|ActionPoint whereSortOrder($value)
 * @method static Builder|ActionPoint whereSportId($value)
 * @method static Builder|ActionPoint whereTitle($value)
 * @method static Builder|ActionPoint whereValues($value)
 * @mixin Eloquent
 */
class ActionPoint extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'action_points';

    protected $fillable = [
        'name',
        'sport_id',
        'values',
        'sort_order',
        'is_enabled',
        'title',
        'alias',
        'game_log_template',
    ];
}
