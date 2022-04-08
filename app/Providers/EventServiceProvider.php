<?php

namespace App\Providers;

use App\Events\CricketGameLogSavedEvent;
use App\Events\CricketGameScheduleSavedEvent;
use App\Events\CricketGameStatsSavedEvent;
use App\Events\CricketPlayerSavedEvent;
use App\Events\CricketTeamSavedEvent;
use App\Events\CricketUnitStatsSavedEvent;
use App\Listeners\CricketGameLogSavedListener;
use App\Listeners\CricketGameScheduleSavedListener;
use App\Listeners\CricketGameStatsSavedListener;
use App\Listeners\CricketPlayerSavedListener;
use App\Listeners\CricketTeamSavedListener;
use App\Listeners\CricketUnitStatsSavedListener;
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
