<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;

it('creates a one to one', function () {
    $manager = Person::factory()->create();
    $person = Person::factory()->create([
        'manager_id' => $manager->id
    ]);
    $action = app(CreateOneToOneAction::class);
    $oneToOneData = new OneToOneData(
        person: $person,
        manager: $manager,
        requester_id: $person->id,
        status: OneToOneStatus::INVITED,
        scheduled_at: now()->addMonth(),
        recurrence_interval: RecurrenceInterval::NEVER
    );

    $action->execute($oneToOneData);

    $this->assertDatabaseHas('one_to_ones', [
        'person_id' => $oneToOneData->person->id,
        'manager_id' => $oneToOneData->manager->id,
        'requester_id' => $oneToOneData->requester_id,
        'status' => $oneToOneData->status,
        'scheduled_at' => $oneToOneData->scheduled_at,
        'recurrence_interval' => RecurrenceInterval::NEVER
    ]);
});
