<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\UpdatePersonProfileAction;
use Domain\People\DataTransferObjects\PersonProfileData;
use Domain\People\Models\Person;

it('updates a persons profile', function () {
    $person = Person::factory()->create();
    $action = app(UpdatePersonProfileAction::class);
    $profileData = new PersonProfileData(
        first_name: 'New',
        last_name: 'Data',
        dob: now(),
        contact_number: '+447123456789',
        contact_email: 'test@test.com',
        title: 'Mrs',
        initials: 'ND',
        pronouns: 'She/Her'
    );

    $action->execute($person, $profileData);

    $this->assertDatabaseHas('people', [
        'title' => $profileData->title,
        'first_name' => $profileData->first_name,
        'last_name' => $profileData->last_name,
        'initials' => $profileData->initials,
        'pronouns' => $profileData->pronouns,
        'dob' => $profileData->dob->toDateString(),
        'contact_number' => $profileData->contact_number,
        'contact_email' => $profileData->contact_email
    ]);
});
