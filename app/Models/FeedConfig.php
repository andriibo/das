<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FeedConfig.
 *
 * @property int    $id
 * @property string $feed
 * @property array  $params
 * @property string $name
 *
 * @method static Builder|FeedConfig newModelQuery()
 * @method static Builder|FeedConfig newQuery()
 * @method static Builder|FeedConfig query()
 * @method static Builder|FeedConfig whereFeed($value)
 * @method static Builder|FeedConfig whereId($value)
 * @method static Builder|FeedConfig whereName($value)
 * @method static Builder|FeedConfig whereParams($value)
 * @mixin Eloquent
 */
class FeedConfig extends Model
{
    public $timestamps = false;

    protected $table = 'feed_config';

    protected $casts = [
        'params' => 'array',
    ];

    protected $fillable = [
        'feed',
        'params',
        'name',
    ];
}
