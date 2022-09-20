<?php

namespace App\Providers;

use Domain\Absences\Events\HolidayCreated;
use Domain\Absences\Events\HolidayDeleted;
use Domain\Absences\Events\HolidayUpdated;
use Domain\Auth\Events\UserCreated;
use Domain\Auth\Events\UserDeleted;
use Domain\Auth\Events\UserUpdated;
use Domain\Absences\Events\SicknessCreated;
use Domain\Absences\Events\SicknessDeleted;
use Domain\Absences\Events\SicknessUpdated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Support\Listeners\LogAction;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        HolidayCreated::class => [
            LogAction::class
        ],
        HolidayUpdated::class => [
            LogAction::class
        ],
        HolidayDeleted::class => [
            LogAction::class
        ],
        SicknessCreated::class => [
            LogAction::class
        ],
        SicknessUpdated::class => [
            LogAction::class
        ],
        SicknessDeleted::class => [
            LogAction::class
        ],
        UserCreated::class => [
            LogAction::class
        ],
        UserUpdated::class => [
            LogAction::class
        ],
        UserDeleted::class => [
            LogAction::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
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
