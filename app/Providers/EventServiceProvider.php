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
use Domain\Expenses\Events\ExpenseCreated;
use Domain\Expenses\Events\ExpenseDeleted;
use Domain\Expenses\Events\ExpenseTypeCreated;
use Domain\Expenses\Events\ExpenseTypeDeleted;
use Domain\Expenses\Events\ExpenseTypeUpdated;
use Domain\Expenses\Events\ExpenseUpdated;
use Domain\Files\Events\DocumentCreated;
use Domain\Files\Events\DocumentDeleted;
use Domain\Files\Events\DocumentUpdated;
use Domain\Notifications\Events\NotificationCreated;
use Domain\Notifications\Events\NotificationUpdated;
use Domain\Organisation\Events\DepartmentCreated;
use Domain\Organisation\Events\DepartmentDeleted;
use Domain\Organisation\Events\DepartmentUpdated;
use Domain\Organisation\Events\OrganisationDeleted;
use Domain\Organisation\Events\OrganisationUpdated;
use Domain\People\Events\AddressCreated;
use Domain\People\Events\AddressDeleted;
use Domain\People\Events\AddressUpdated;
use Domain\People\Events\PersonCreated;
use Domain\People\Events\PersonDeleted;
use Domain\People\Events\PersonUpdated;
use Domain\Performance\Events\ObjectiveCreated;
use Domain\Performance\Events\ObjectiveDeleted;
use Domain\Performance\Events\ObjectiveUpdated;
use Domain\Performance\Events\OneToOneCreated;
use Domain\Performance\Events\OneToOneDeleted;
use Domain\Performance\Events\OneToOneUpdated;
use Domain\Performance\Events\TaskCreated;
use Domain\Performance\Events\TaskDeleted;
use Domain\Performance\Events\TaskUpdated;
use Domain\Performance\Events\TrainingCreated;
use Domain\Performance\Events\TrainingDeleted;
use Domain\Performance\Events\TrainingUpdated;
use Domain\Recruitment\Events\ApplicationCreated;
use Domain\Recruitment\Events\ApplicationDeleted;
use Domain\Recruitment\Events\ApplicationUpdated;
use Domain\Recruitment\Events\VacancyCreated;
use Domain\Recruitment\Events\VacancyDeleted;
use Domain\Recruitment\Events\VacancyUpdated;
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
        ],
        ExpenseCreated::class => [
            LogAction::class
        ],
        ExpenseUpdated::class => [
            LogAction::class
        ],
        ExpenseDeleted::class => [
            LogAction::class
        ],
        ExpenseTypeCreated::class => [
            LogAction::class
        ],
        ExpenseTypeUpdated::class => [
            LogAction::class
        ],
        ExpenseTypeDeleted::class => [
            LogAction::class
        ],
        DocumentCreated::class => [
            LogAction::class
        ],
        DocumentUpdated::class => [
            LogAction::class
        ],
        DocumentDeleted::class => [
            LogAction::class
        ],
        NotificationCreated::class => [
            LogAction::class
        ],
        NotificationUpdated::class => [
            LogAction::class
        ],
        DepartmentCreated::class => [
            LogAction::class
        ],
        DepartmentUpdated::class => [
            LogAction::class
        ],
        DepartmentDeleted::class => [
            LogAction::class
        ],
        OrganisationUpdated::class => [
            LogAction::class
        ],
        OrganisationDeleted::class => [
            LogAction::class
        ],
        AddressCreated::class => [
            LogAction::class
        ],
        AddressUpdated::class => [
            LogAction::class
        ],
        AddressDeleted::class => [
            LogAction::class
        ],
        PersonCreated::class => [
            LogAction::class
        ],
        PersonUpdated::class => [
            LogAction::class
        ],
        PersonDeleted::class => [
            LogAction::class
        ],
        ObjectiveCreated::class => [
            LogAction::class
        ],
        ObjectiveUpdated::class => [
            LogAction::class
        ],
        ObjectiveDeleted::class => [
            LogAction::class
        ],
        OneToOneCreated::class => [
            LogAction::class
        ],
        OneToOneUpdated::class => [
            LogAction::class
        ],
        OneToOneDeleted::class => [
            LogAction::class
        ],
        TaskCreated::class => [
            LogAction::class
        ],
        TaskUpdated::class => [
            LogAction::class
        ],
        TaskDeleted::class => [
            LogAction::class
        ],
        TrainingCreated::class => [
            LogAction::class
        ],
        TrainingUpdated::class => [
            LogAction::class
        ],
        TrainingDeleted::class => [
            LogAction::class
        ],
        ApplicationCreated::class => [
            LogAction::class
        ],
        ApplicationUpdated::class => [
            LogAction::class
        ],
        ApplicationDeleted::class => [
            LogAction::class
        ],
        VacancyCreated::class => [
            LogAction::class
        ],
        VacancyUpdated::class => [
            LogAction::class
        ],
        VacancyDeleted::class => [
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
