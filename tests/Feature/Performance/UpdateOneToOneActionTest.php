<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\UpdateOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;

it('updates the one-to-one', function () {
    $manager = Person::factory()->create();
    $person = Person::factory()->create([
        'manager_id' => $manager->id
    ]);
    $oneToOne = OneToOne::factory()
        ->create([
            'person_id' => $person->id,
            'manager_id' => $manager->id,
            'requester_id' => $person->id
        ]);

    $action = app(UpdateOneToOneAction::class);
    $oneToOneData = new OneToOneData(
        person: $person,
        manager: $manager,
        requester_id: $person->id,
        person_status: OneToOneStatus::ACCEPTED,
        manager_status: OneToOneStatus::ACCEPTED,
        scheduled_at: $oneToOne->scheduled_at
    );

    $this->assertModelExists($oneToOne);

    $action->execute($oneToOne, $oneToOneData);

    $this->assertDatabaseHas('one_to_ones', [
        'person_id' => $oneToOneData->person->id,
        'manager_id' => $oneToOneData->manager->id,
        'requester_id' => $oneToOneData->person->id,
        'person_status' => OneToOneStatus::ACCEPTED,
        'manager_status' => OneToOneStatus::ACCEPTED,
        'scheduled_at' => $oneToOneData->scheduled_at
    ]);
});
