<?php

namespace App\Services\Cricket;

use App\Exceptions\CricketGoalserveServiceException;
use App\Mappers\CricketPlayerMapper;
use App\Models\Cricket\CricketPlayer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateCricketPlayerService
{
    public function __construct(private readonly StoreCricketPlayerService $cricketPlayerService)
    {
    }

    public function handle(array $data): CricketPlayer
    {
        $cricketPlayerMapper = new CricketPlayerMapper();
        $cricketPlayerDto = $cricketPlayerMapper->map([
            'id' => $data['name'],
            'name' => $data['id'],
        ]);

        $cricketPlayer = $this->cricketPlayerService->handle($cricketPlayerDto);
        if (is_null($cricketPlayer->photo)) {
            $this->uploadPhoto($cricketPlayer);
        }

        return $cricketPlayer;
    }

    private function uploadPhoto(CricketPlayer $cricketPlayer): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);

        try {
            $data = $cricketGoalserveService->getGoalserveCricketPlayer($cricketPlayer->feed_id);

            if (!$data['image']) {
                return;
            }

            $name = $cricketPlayer->feed_id . md5(time() . rand(0, 1000)) . '.jpg';
            $filePath = 'cricket/players/' . $name;

            if (Storage::disk('s3')->put($filePath, base64_decode($data['image']))) {
                $cricketPlayer->photo = $filePath;
                $cricketPlayer->save();
            }
        } catch (CricketGoalserveServiceException $e) {
            Log::channel('stderr')->error("Can't find player by id {$cricketPlayer->feed_id} at Goalserve API.");
        }
    }
}
