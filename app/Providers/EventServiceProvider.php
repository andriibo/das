<?php

namespace App\Providers;

use App\Events\CricketGameScheduleSavedEvent;
use App\Events\CricketPlayerSavedEvent;
use App\Events\CricketTeamSavedEvent;
use App\Events\CricketUnitStatSavedEvent;
use App\Listeners\CricketGameScheduleSavedListener;
use App\Listeners\CricketPlayerSavedListener;
use App\Listeners\CricketTeamSavedListener;
use App\Listeners\CricketUnitStatSavedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CricketTeamSavedEvent::class => [
            CricketTeamSavedListener::class,
        ],
        CricketPlayerSavedEvent::class => [
            CricketPlayerSavedListener::class,
        ],
        CricketGameScheduleSavedEvent::class => [
            CricketGameScheduleSavedListener::class,
        ],
        CricketUnitStatSavedEvent::class => [
            CricketUnitStatSavedListener::class,
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
