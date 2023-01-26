<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\RemovePersonAction;
use Domain\People\DataTransferObjects\RemovePersonData;
use Domain\People\Models\Person;

it('removes the person and user', function () {
    $user = User::factory()->create();
    $person = Person::factory()->for($user)->create();
    Person::factory()
        ->count(3)
        ->create([
            'manager_id' => $person->id
        ]);

    $removePersonData = RemovePersonData::from([
        'person' => $person,
        'user' => $user
    ]);

    $action = app(RemovePersonAction::class);

    $this->assertNotSoftDeleted($person);
    $this->assertNotSoftDeleted($user);

    $action->execute($removePersonData);

    expect(
        Person::query()
            ->where('manager_id', $person->id)
            ->count()
    )->toBe(0);

    $this->assertSoftDeleted($person);
    $this->assertSoftDeleted($user);
});
