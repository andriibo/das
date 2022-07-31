<?php

namespace App\Providers;

use App\Events\ContestUnitsUpdatedEvent;
use App\Events\Cricket\CricketGameLogSavedEvent;
use App\Events\Cricket\CricketGameScheduleSavedEvent;
use App\Events\Cricket\CricketGameStatsSavedEvent;
use App\Events\Cricket\CricketPlayerSavedEvent;
use App\Events\Cricket\CricketTeamSavedEvent;
use App\Events\Cricket\CricketUnitSavedEvent;
use App\Events\Cricket\CricketUnitStatsSavedEvent;
use App\Events\GameLogsUpdatedEvent;
use App\Listeners\ContestUnitsUpdatedListener;
use App\Listeners\Cricket\CricketGameLogSavedListener;
use App\Listeners\Cricket\CricketGameScheduleSavedListener;
use App\Listeners\Cricket\CricketGameStatsSavedListener;
use App\Listeners\Cricket\CricketPlayerSavedListener;
use App\Listeners\Cricket\CricketTeamSavedListener;
use App\Listeners\Cricket\CricketUnitSavedListener;
use App\Listeners\Cricket\CricketUnitStatsSavedListener;
use App\Listeners\GameLogsUpdatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        CricketTeamSavedEvent::class => [
            CricketTeamSavedListener::class,
        ],
        CricketPlayerSavedEvent::class => [
            CricketPlayerSavedListener::class,
        ],
        CricketGameScheduleSavedEvent::class => [
            CricketGameScheduleSavedListener::class,
        ],
        CricketGameStatsSavedEvent::class => [
            CricketGameStatsSavedListener::class,
        ],
        CricketUnitStatsSavedEvent::class => [
            CricketUnitStatsSavedListener::class,
        ],
        CricketGameLogSavedEvent::class => [
            CricketGameLogSavedListener::class,
        ],
        CricketUnitSavedEvent::class => [
            CricketUnitSavedListener::class,
        ],
        ContestUnitsUpdatedEvent::class => [
            ContestUnitsUpdatedListener::class,
        ],
        GameLogsUpdatedEvent::class => [
            GameLogsUpdatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
