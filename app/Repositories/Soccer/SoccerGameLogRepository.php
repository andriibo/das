<?php

namespace App\Repositories\Soccer;

use App\Enums\SportIdEnum;
use App\Models\Soccer\SoccerGameLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SoccerGameLogRepository
{
    public function getGameLogsByContestId(int $contestId): LengthAwarePaginator
    {
        return SoccerGameLog::query()
            ->join('contest_game', 'game_log.game_id', '=', 'contest_game.game_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::soccer)
            ->orderBy('id', 'desc')
            ->jsonPaginate()
            ;
    }
}
