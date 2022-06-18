<?php

namespace App\Services;

use App\Mappers\CricketPlayerMapper;
use App\Models\CricketPlayer;
use Illuminate\Support\Facades\Storage;

class CreateCricketPlayerService
{
    public function __construct(private readonly CricketPlayerService $cricketPlayerService)
    {
    }

    public function handle(array $data): CricketPlayer
    {
        $cricketPlayerMapper = new CricketPlayerMapper();
        $cricketPlayerDto = $cricketPlayerMapper->map([
            'id' => $data['name'],
            'name' => $data['id'],
        ]);

        $cricketPlayer = $this->cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
        if (is_null($cricketPlayer->photo)) {
            $this->uploadPhoto($cricketPlayer);
        }

        return $cricketPlayer;
    }

    private function uploadPhoto(CricketPlayer $cricketPlayer): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
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
    }
}
