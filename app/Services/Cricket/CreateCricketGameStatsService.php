<?php

namespace App\Services\Cricket;

use App\Const\CricketGameScheduleConst;
use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Mappers\CricketGameStatsMapper;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\League;
use App\Repositories\ContestRepository;
use App\Repositories\Cricket\CricketGameLogRepository;
use App\Services\CalculateContestService;
use Illuminate\Support\Facades\Log;

class CreateCricketGameStatsService
{
    public function __construct(
        private readonly CreateCricketUnitStatsService $createCricketUnitStatsService,
        private readonly CalculateContestService $calculateContestService,
        private readonly CricketGoalserveService $cricketGoalserveService,
        private readonly CricketGameStatsMapper $cricketGameStatsMapper,
        private readonly CricketGameStatsService $cricketGameStatsService
    ) {
    }

    public function handle(League $league)
    {
        $contestRepository = new ContestRepository();
        $cricketGameLogRepository = new CricketGameLogRepository();
        $runningContests = $contestRepository->getRunningContests($league->id);
        $gamesLoaded = $gamesConfirmed = [];
        foreach ($runningContests as $contest) {
            $lastGameLogId = 0;
            $lastGameLog = $cricketGameLogRepository->getLastGameLogByContestId($contest->id);
            if ($lastGameLog) {
                $lastGameLogId = $lastGameLog->id;
            }
            $liveGames = $contest->liveCricketGameSchedules()->whereNotIn('id', $gamesLoaded)->get();
            foreach ($liveGames as $liveGame) {
                $this->parseGameStats($liveGame);
                $gamesLoaded[] = $liveGame->id;
            }
            $unconfirmedGames = $contest->unconfirmedCricketGameSchedules()->whereNotIn('id', $gamesLoaded)->get();
            foreach ($unconfirmedGames as $unconfirmedGame) {
                if ($unconfirmedGame->has_final_box && $unconfirmedGame->updated_at < date('Y-m-d H:i:s', time() - CricketGameScheduleConst::CONFIRM_STATS_DELAY)) {
                    $this->confirmGameStats($unconfirmedGame);
                    $gamesLoaded[] = $unconfirmedGame->id;
                    $gamesConfirmed[] = $unconfirmedGame->id;
                }
            }
            $lastGameLog = $cricketGameLogRepository->getLastGameLogByContestId($contest->id);
            if ($lastGameLog && $lastGameLog->id > $lastGameLogId && !empty($gamesConfirmed)) {
                $this->calculateContestService->handle($contest);
            }
        }
    }

    private function confirmGameStats(CricketGameSchedule $cricketGameSchedule): void
    {
        $this->parseGameStats($cricketGameSchedule);

        if ($cricketGameSchedule->has_final_box == HasFinalBoxEnum::no->value) {
            throw new \Exception('Trying to confirm unfinished Game Schedule');
        }

        $cricketGameSchedule->is_data_confirmed = IsDataConfirmedEnum::yes;
        $cricketGameSchedule->save();
    }

    private function parseGameStats(CricketGameSchedule $cricketGameSchedule): void
    {
        try {
            $formattedDate = $this->getFormattedDate($cricketGameSchedule->game_date);
            $data = $this->cricketGoalserveService->getGoalserveGameStats($formattedDate, $cricketGameSchedule->feed_id);

            if (empty($data)) {
                Log::channel('stderr')->error("No data for date {$formattedDate} and feed_id {$cricketGameSchedule->feed_id}");

                return;
            }

            $cricketGameStatsDto = $this->cricketGameStatsMapper->map($data);
            $cricketGameStats = $this->cricketGameStatsService->storeCricketGameStats($cricketGameStatsDto);
            $this->createCricketUnitStatsService->handle($cricketGameStats);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
        }
    }

    private function getFormattedDate(string $dateTime): string
    {
        $dateTime = new \DateTime($dateTime);

        return $dateTime->format('d.m.Y');
    }
}
