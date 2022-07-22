<?php

namespace App\Services\Cricket;

use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
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
        private readonly CreateCricketGameScheduleService $createCricketGameScheduleService,
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
            $cricketGameScheduleDto = $this->cricketGameScheduleMapper->map($data['match'], $cricketGameSchedule->league_id);
            $cricketGameScheduleDto->isFake = IsFakeEnum::tryFrom($cricketGameSchedule->is_fake);
            $cricketGameSchedule = $this->createCricketGameScheduleService->handle($cricketGameScheduleDto);
            if (empty($data)) {
                Log::channel('stderr')->error("No data for date {$formattedDate} and feed_id {$cricketGameSchedule->feed_id}");

                return;
            }

            $cricketGameStatsDto = $this->cricketGameStatsMapper->map($data, $cricketGameSchedule->id);
            $cricketGameStats = $this->storeCricketGameStatsService->handle($cricketGameStatsDto);
            $this->createCricketUnitStatsService->handle($cricketGameStats);
            if (!$cricketGameSchedule->hasFinalBox() && CricketGameScheduleHelper::isStatusLive($cricketGameSchedule->status)) {
                $cricketGameSchedule->has_final_box = HasFinalBoxEnum::yes;
                $cricketGameSchedule->save();
            }
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
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
}
