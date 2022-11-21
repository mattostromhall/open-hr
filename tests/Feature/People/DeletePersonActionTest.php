<?php

use Domain\People\Actions\DeletePersonAction;
use Domain\People\Models\Person;

it('deletes the person', function () {
    $person = Person::factory()->create();
    $action = app(DeletePersonAction::class);

    $this->assertNotSoftDeleted($person);

    $action->execute($person);

    $this->assertSoftDeleted($person);
});
