<?php

use Domain\People\Actions\BulkDeletePeopleAction;
use Domain\People\Models\Person;

it('bulk deletes the people', function () {
    $people = Person::factory()->count(3)->create();
    $action = app(BulkDeletePeopleAction::class);

    $people->each(fn (Person $person) => $this->assertNotSoftDeleted($person));

    $action->execute($people->pluck('user_id')->toArray());

    $people->each(fn (Person $person) => $this->assertSoftDeleted($person));
});
