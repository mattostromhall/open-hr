<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\DeletePersonUserAction;
use Domain\People\Models\Person;

it('deletes the person and user', function () {
    $user = User::factory()->create();
    $person = Person::factory()->for($user)->create();

    $action = app(DeletePersonUserAction::class);

    $this->assertNotSoftDeleted($person);
    $this->assertNotSoftDeleted($user);

    $action->execute($person, $user);

    $this->assertSoftDeleted($person);
    $this->assertSoftDeleted($user);
});
