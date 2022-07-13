<?php

namespace App\Repositories\Cricket;

use App\Enums\Contests\StatusEnum;
use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class CricketGameScheduleRepository
{
    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getGameSchedulesByContestId(int $contestId): Collection
    {
        return CricketGameSchedule::query()
            ->join('contest_game', 'cricket_game_schedule.id', '=', 'contest_game.game_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::cricket)
            ->get()
            ;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getNotFakeByFeedId(string $feedId): CricketGameSchedule
    {
        return CricketGameSchedule::whereFeedId($feedId)
            ->where('is_fake', IsFakeEnum::no)
            ->firstOrFail()
        ;
    }

    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getActiveByFeedIdAndLeagueId(string $feedId, int $leagueId): Collection
    {
        return CricketGameSchedule::whereFeedId($feedId)
            ->where('league_id', $leagueId)
            ->whereHas('contestGames.contest', function (Builder $query) {
                $query->whereNotIn('status', [StatusEnum::closed->value, StatusEnum::cancelled->value]);
            })
            ->get()
        ;
    }

    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getList(): Collection
    {
        return CricketGameSchedule::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketGameSchedule
    {
        return CricketGameSchedule::updateOrCreate($attributes, $values);
    }

    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getHistorical(int $leagueId): Collection
    {
        return CricketGameSchedule::query()
            ->where('league_id', $leagueId)
            ->where('game_date', '<', date('Y-m-d H:i:s'))
            ->where('has_final_box', HasFinalBoxEnum::yes)
            ->where('is_fake', IsFakeEnum::no)
            ->orderByDesc('game_date')
            ->get()
        ;
    }
}
