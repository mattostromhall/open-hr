<?php

use Domain\People\Actions\CreatePersonAction;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Enums\RemunerationInterval;
use Shared\Models\User;

it('creates a person', function () {
    $user = User::factory()->create();
    $action = app(CreatePersonAction::class);
    $personData = new PersonData(
        user: $user,
        manager: null,
        department: null,
        title: null,
        first_name: '',
        last_name: '',
        initials: null,
        pronouns: '',
        dob: '',
        position: '',
        remuneration: 50,
        remuneration_interval: RemunerationInterval::MONTHLY,
        holiday_allocation: 25,
        sickness_allocation: 25,
        contact_number: '+447123456789',
        contact_email: 'test@test.com',
        started_on: now()
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
        'dob' => $personData->dob,
        'position' => $personData->position,
        'remuneration' => $personData->remuneration,
        'remuneration_interval' => $personData->remuneration_interval,
        'holiday_allocation' => $personData->holiday_allocation,
        'sickness_allocation' => $personData->sickness_allocation,
        'contact_number' => $personData->contact_number,
        'contact_email' => $personData->contact_email,
        'started_on' => $personData->started_on,
        'finished_on' => $personData->finished_on
    ]);
});
