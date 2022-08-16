<?php

namespace App\Services\Cricket;

use App\Dto\CricketGameScheduleDto;
use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Events\SendExceptionEvent;
use App\Helpers\CricketGameScheduleHelper;
use App\Mappers\CricketGameScheduleMapper;
use App\Mappers\CricketGameStatsMapper;
use App\Models\Cricket\CricketGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;
use Illuminate\Support\Facades\Log;

class CreateCricketGameStatsService
{
    public function __construct(
        private readonly CricketGoalserveService $cricketGoalserveService,
        private readonly CricketGameStatsMapper $cricketGameStatsMapper,
        private readonly StoreCricketGameStatsService $storeCricketGameStatsService,
        private readonly CreateCricketUnitStatsService $createCricketUnitStatsService,
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly CricketGameScheduleMapper $cricketGameScheduleMapper,
    ) {
    }

    public function handle(CricketGameSchedule $cricketGameSchedule): void
    {
        try {
            $leagueFeedId = $cricketGameSchedule->league->params['league_id'];
            $gameDate = $this->getGameDate($cricketGameSchedule);
            $formattedDate = $this->getFormattedDate($gameDate);
            $data = $this->cricketGoalserveService->getGoalserveGameStats($formattedDate, $leagueFeedId, $cricketGameSchedule->feed_id);
            if (empty($data)) {
                Log::channel('stderr')->error("No data for date {$formattedDate} and feed_id {$cricketGameSchedule->feed_id}");

                return;
            }
            $cricketGameScheduleDto = $this->cricketGameScheduleMapper->map($data['match'], $cricketGameSchedule->league_id);
            $cricketGameSchedule = $this->updateCricketGameSchedule($cricketGameSchedule, $cricketGameScheduleDto);
            $cricketGameStatsDto = $this->cricketGameStatsMapper->map($data, $cricketGameSchedule->id);
            $cricketGameStats = $this->storeCricketGameStatsService->handle($cricketGameStatsDto);
            $this->createCricketUnitStatsService->handle($cricketGameStats);
        } catch (\Throwable $exception) {
            event(new SendExceptionEvent($exception));
        }
    }

    private function getFormattedDate(string $dateTime): string
    {
        $dateTime = new \DateTime($dateTime);

        return $dateTime->format('d.m.Y');
    }

    private function getGameDate(CricketGameSchedule $cricketGameSchedule): string
    {
        if ($cricketGameSchedule->isFake()) {
            $notFakeCricketGameSchedule = $this->cricketGameScheduleRepository->getNotFakeByFeedId($cricketGameSchedule->feed_id);

            return $notFakeCricketGameSchedule->game_date;
        }

        return $cricketGameSchedule->game_date;
    }

    private function updateCricketGameSchedule(CricketGameSchedule $cricketGameSchedule, CricketGameScheduleDto $cricketGameScheduleDto): CricketGameSchedule
    {
        $cricketGameSchedule->home_team_score = $cricketGameScheduleDto->homeTeamScore;
        $cricketGameSchedule->away_team_score = $cricketGameScheduleDto->awayTeamScore;
        $cricketGameSchedule->status = $cricketGameScheduleDto->status;
        $cricketGameSchedule->type = $cricketGameScheduleDto->type;
        if (!$cricketGameSchedule->hasFinalBox() && CricketGameScheduleHelper::isStatusLive($cricketGameScheduleDto->status->value)) {
            $cricketGameSchedule->has_final_box = HasFinalBoxEnum::yes;
            $cricketGameSchedule->save();
        }

        return $cricketGameSchedule;
    }
}
