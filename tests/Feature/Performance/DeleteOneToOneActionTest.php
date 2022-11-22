<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\DeleteOneToOneAction;
use Domain\Performance\Models\OneToOne;

it('deletes the one-to-one', function () {
    $person = Person::factory()->create();
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $person->id,
        'requester_id' => $person->id
    ]);
    $action = app(DeleteOneToOneAction::class);

    $this->assertNotSoftDeleted($oneToOne);

    $action->execute($oneToOne);

    $this->assertSoftDeleted($oneToOne);
});
