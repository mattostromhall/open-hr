<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;

it('creates a one to one', function () {
    $manager = Person::factory()->create();
    $person = Person::factory()->create([
        'manager_id' => $manager->id
    ]);
    $action = app(CreateOneToOneAction::class);
    $oneToOneData = new OneToOneData(
        person: $person,
        manager: $manager,
        status: OneToOneStatus::INVITED,
        scheduled_at: now()->addMonth()
    );

    $action->execute($oneToOneData);

    $this->assertDatabaseHas('one_to_ones', [
        'person_id' => $oneToOneData->person->id,
        'manager_id' => $oneToOneData->manager->id,
        'status' => $oneToOneData->status,
        'scheduled_at' => $oneToOneData->scheduled_at
    ]);
});
