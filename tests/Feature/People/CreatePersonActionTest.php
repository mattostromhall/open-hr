<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\CreatePersonAction;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Enums\RemunerationInterval;
use Support\Enums\Currency;

it('creates a person', function () {
    $user = User::factory()->create();
    $action = app(CreatePersonAction::class);
    $personData = new PersonData(
        user: $user,
        first_name: '',
        last_name: '',
        dob: now(),
        position: '',
        remuneration: 50,
        remuneration_interval: RemunerationInterval::MONTHLY,
        remuneration_currency: Currency::GBP,
        holiday_allocation: 25,
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

    $action->execute($personData);

    $this->assertDatabaseHas('people', [
        'user_id' => $personData->user->id,
        'manager_id' => $personData->manager?->id,
        'department_id' => $personData->department?->id,
        'title' => $personData->title,
        'first_name' => $personData->first_name,
        'last_name' => $personData->last_name,
        'initials' => $personData->initials,
        'pronouns' => $personData->pronouns,
        'dob' => $personData->dob->toDateString(),
        'position' => $personData->position,
        'remuneration' => $personData->remuneration,
        'remuneration_interval' => $personData->remuneration_interval,
        'remuneration_currency' => $personData->remuneration_currency,
        'holiday_allocation' => $personData->holiday_allocation,
        'sickness_allocation' => $personData->sickness_allocation,
        'contact_number' => $personData->contact_number,
        'contact_email' => $personData->contact_email,
        'started_on' => $personData->started_on->toDateString(),
        'finished_on' => $personData->finished_on
    ]);
});
