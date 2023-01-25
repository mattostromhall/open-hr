<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\DeletePersonUserAction;
use Domain\People\DataTransferObjects\DeletePersonData;
use Domain\People\Models\Person;

it('deletes the person and user', function () {
    $user = User::factory()->create();
    $person = Person::factory()->for($user)->create();
    $deletePersonData = DeletePersonData::from([
        'person' => $person,
        'user' => $user
    ]);

    $action = app(DeletePersonUserAction::class);

    $this->assertNotSoftDeleted($person);
    $this->assertNotSoftDeleted($user);

    $action->execute($deletePersonData);

    $this->assertSoftDeleted($person);
    $this->assertSoftDeleted($user);
});
