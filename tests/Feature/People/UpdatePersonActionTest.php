<?php

use Domain\People\Actions\UpdatePersonAction;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Support\Enums\Currency;

it('updates a person', function () {
    $person = Person::factory()->create();
    $action = app(UpdatePersonAction::class);
    $personData = new PersonData(
        user: $person->user,
        first_name: 'New',
        last_name: 'Name',
        dob: now(),
        position: 'Updated',
        remuneration: 50,
        remuneration_interval: RemunerationInterval::MONTHLY,
        remuneration_currency: Currency::GBP,
        base_holiday_allocation: 25,
        sickness_allocation: 10,
        contact_number: '+447123456789',
        contact_email: 'test@test.com',
        started_on: now(),
        manager: null,
        department: null,
        title: 'Mr',
        initials: 'NN',
        pronouns: '',
        finished_on: null
    );

    $this->assertModelExists($person);

    $action->execute($person, $personData);

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
        'base_holiday_allocation' => $personData->base_holiday_allocation,
        'holiday_carry_allocation' => 0,
        'holiday_carried' => 0,
        'sickness_allocation' => $personData->sickness_allocation,
        'contact_number' => $personData->contact_number,
        'contact_email' => $personData->contact_email,
        'started_on' => $personData->started_on->toDateString(),
        'finished_on' => $personData->finished_on
    ]);
});
