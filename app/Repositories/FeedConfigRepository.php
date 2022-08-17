<?php

namespace App\Repositories;

use App\Models\FeedConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FeedConfigRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getGoalserveConfig(): FeedConfig
    {
        return FeedConfig::query()
            ->where('feed', 'goalserve')
            ->firstOrFail()
        ;
    }
}
