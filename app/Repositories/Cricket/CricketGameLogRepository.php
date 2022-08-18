<?php

namespace App\Repositories\Cricket;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameLog;
use Illuminate\Support\Collection;

class CricketGameLogRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketGameLog
    {
        return CricketGameLog::updateOrCreate($attributes, $values);
    }

    /**
     * @return Collection|CricketGameLog[]
     */
    public function getGameLogsByContestId(int $contestId): Collection
    {
        return CricketGameLog::query()
            ->join('contest_game', 'cricket_game_log.game_schedule_id', '=', 'contest_game.game_schedule_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::cricket)
            ->get()
            ;
    }

    public function getLastGameLogByContestId(int $contestId): ?CricketGameLog
    {
        return CricketGameLog::query()
            ->join('contest_game', 'cricket_game_log.game_schedule_id', '=', 'contest_game.game_schedule_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::cricket)
            ->orderByDesc('id')
            ->first()
            ;
    }
}
