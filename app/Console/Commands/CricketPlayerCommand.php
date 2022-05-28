<?php

namespace App\Console\Commands;

use App\Mappers\CricketPlayerMapper;
use App\Models\CricketPlayer;
use App\Repositories\CricketPlayerRepository;
use App\Services\CricketGoalserveService;
use App\Services\CricketPlayerService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CricketPlayerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:player';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get players for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(CricketPlayerRepository $cricketPlayerRepository)
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketPlayers = $cricketPlayerRepository->getList();
        foreach ($cricketPlayers as $cricketPlayer) {
            $this->parseCricketPlayer($cricketPlayer);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseCricketPlayer(CricketPlayer $cricketPlayer): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService
         * @var $cricketPlayerService CricketPlayerService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $cricketPlayerService = resolve(CricketPlayerService::class);
        $cricketPlayerMapper = new CricketPlayerMapper();

        try {
            $data = $cricketGoalserveService->getGoalserveCricketPlayer($cricketPlayer->feed_id);
            if (empty($data)) {
                $this->error("No data for player with feed_id {$cricketPlayer->feed_id}");

                return;
            }

            if (is_null($cricketPlayer->photo) && $data['image']) {
                $data['photo'] = $this->uploadPhoto($data['image']);
            }
            $cricketPlayerDto = $cricketPlayerMapper->map($data);
            $cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function uploadPhoto(string $image): ?string
    {
        $name = time() . '.jpg';
        $filePath = 'cricket/players/' . $name;

        if (Storage::disk('s3')->put($filePath, base64_decode($image))) {
            return $filePath;
        }

        return null;
    }
}
