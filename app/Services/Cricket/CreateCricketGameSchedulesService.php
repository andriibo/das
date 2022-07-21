<?php

namespace App\Services\Cricket;

use App\Dto\CricketGameScheduleDto;
use App\Mappers\CricketGameScheduleMapper;
use App\Models\League;
use App\Repositories\Cricket\CricketGameScheduleRepository;
use Illuminate\Support\Facades\Log;

class CreateCricketGameSchedulesService
{
    public function __construct(
        private readonly CricketGoalserveService $cricketGoalserveService,
        private readonly CricketGameScheduleMapper $cricketGameScheduleMapper,
        private readonly ConfirmCricketGameScheduleService $confirmCricketGameScheduleService,
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository
    ) {
    }

    public function handle(League $league): void
    {
        try {
            $leagueId = $league->params['league_id'];
            $matches = $this->cricketGoalserveService->getGoalserveCricketMatches($leagueId);
            foreach ($matches as $match) {
                $cricketGameScheduleDto = $this->cricketGameScheduleMapper->map($match, $leagueId);
                $this->parseMatch($cricketGameScheduleDto);
            }
        } catch (\Throwable $exception) {
            Log::channel('stderr')->error($exception->getMessage());
        }
    }

    private function parseMatch(CricketGameScheduleDto $cricketGameScheduleDto): void
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getActiveByFeedIdAndLeagueId(
            $cricketGameScheduleDto->feedId,
            $cricketGameScheduleDto->leagueId
        );

        $updateData = [
            'home_team_id' => $cricketGameScheduleDto->homeTeamId,
            'away_team_id' => $cricketGameScheduleDto->awayTeamId,
            'game_date' => $cricketGameScheduleDto->gameDate,
            'has_final_box' => $cricketGameScheduleDto->hasFinalBox->value,
            'home_team_score' => $cricketGameScheduleDto->homeTeamScore,
            'away_team_score' => $cricketGameScheduleDto->awayTeamScore,
            'is_salary_available' => $cricketGameScheduleDto->isSalaryAvailable->value,
            'feed_type' => $cricketGameScheduleDto->feedType->name,
            'status' => $cricketGameScheduleDto->status->value,
            'type' => $cricketGameScheduleDto->type->value,
        ];

        if ($cricketGameSchedules->isEmpty()) {
            $cricketGameSchedule = $this->cricketGameScheduleRepository->updateOrCreate([
                'feed_id' => $cricketGameScheduleDto->feedId,
                'league_id' => $cricketGameScheduleDto->leagueId,
            ], array_merge($updateData, ['is_fake' => $cricketGameScheduleDto->isFake->value]));
            $this->confirmCricketGameScheduleService->handle($cricketGameSchedule);

            return;
        }

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            $cricketGameSchedule = $this->cricketGameScheduleRepository->updateOrCreate([
                'id' => $cricketGameSchedule->id,
                'feed_id' => $cricketGameScheduleDto->feedId,
                'league_id' => $cricketGameScheduleDto->leagueId,
            ], array_merge($updateData, ['is_fake' => $cricketGameSchedule->is_fake]));

            $this->confirmCricketGameScheduleService->handle($cricketGameSchedule);
        }
    }
}
