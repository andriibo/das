<?php

namespace App\Repositories;

use App\Models\CricketGameLog;

class CricketGameLogRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketGameLog
    {
        return CricketGameLog::updateOrCreate($attributes, $values);
    }
}
