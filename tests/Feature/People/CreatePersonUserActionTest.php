<?php

use Domain\Auth\DataTransferObjects\UserData;
use Domain\People\Actions\CreatePersonUserAction;
use Domain\People\DataTransferObjects\PersonUserData;
use Domain\People\Enums\RemunerationInterval;
use Support\Enums\Currency;

it('creates a person and a user', function () {
    $action = app(CreatePersonUserAction::class);
    $userData = new UserData(email: 'test@test.com', password: 'password');
    $personUserData = new PersonUserData(
        user_data: $userData,
        first_name: '',
        last_name: '',
        dob: now(),
        position: '',
        remuneration: 50,
        remuneration_interval: RemunerationInterval::MONTHLY,
        remuneration_currency: Currency::GBP,
        base_holiday_allocation: 25,
        sickness_allocation: 25,
        contact_number: '+447123456789',
        contact_email: 'test@test.com',
        started_on: now(),
        manager: null,
        department: null,
        title: null,
        initials: null,
        pronouns: '',
        finished_on: null
    );

    [$user, $person] = $action->execute($personUserData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => 'test@test.com'
    ]);

    $this->assertDatabaseHas('people', [
        'id' => $person->id,
        'user_id' => $user->id,
        'manager_id' => $personUserData->manager?->id,
        'department_id' => $personUserData->department?->id,
        'title' => $personUserData->title,
        'first_name' => $personUserData->first_name,
        'last_name' => $personUserData->last_name,
        'initials' => $personUserData->initials,
        'pronouns' => $personUserData->pronouns,
        'dob' => $personUserData->dob->toDateString(),
        'position' => $personUserData->position,
        'remuneration' => $personUserData->remuneration,
        'remuneration_interval' => $personUserData->remuneration_interval,
        'remuneration_currency' => $personUserData->remuneration_currency,
        'base_holiday_allocation' => $personUserData->base_holiday_allocation,
        'holiday_carry_allocation' => 0,
        'holiday_carried' => 0,
        'sickness_allocation' => $personUserData->sickness_allocation,
        'contact_number' => $personUserData->contact_number,
        'contact_email' => $personUserData->contact_email,
        'started_on' => $personUserData->started_on->toDateString(),
        'finished_on' => $personUserData->finished_on
    ]);
});
