<?php

namespace App\Providers;

use App\Events\CricketGameScheduleSavedEvent;
use App\Events\CricketGameStatSavedEvent;
use App\Events\CricketPlayerSavedEvent;
use App\Events\CricketTeamSavedEvent;
use App\Events\CricketUnitStatsSavedEvent;
use App\Listeners\CricketGameScheduleSavedListener;
use App\Listeners\CricketGameStatSavedListener;
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
        CricketGameStatSavedEvent::class => [
            CricketGameStatSavedListener::class,
        ],
        CricketUnitStatsSavedEvent::class => [
            CricketUnitStatsSavedListener::class,
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
