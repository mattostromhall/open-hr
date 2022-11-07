<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateOneToOneRecurrenceAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Models\OneToOne;

it('creates a one to one recurrence', function () {
    $person = Person::factory()->create();
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $person->id,
        'requester_id' => $person->id,
        'recurring' => true,
        'recurrence_interval' => RecurrenceInterval::MONTHLY,
        'completed_at' => now()
    ]);

    $action = app(CreateOneToOneRecurrenceAction::class);
    $oneToOneData = new OneToOneData(
        person: $oneToOne->person,
        manager: $oneToOne->manager,
        requester_id: $oneToOne->requester_id,
        person_status: $oneToOne->person_status,
        manager_status: $oneToOne->manager_status,
        scheduled_at: $oneToOne->scheduled_at,
        recurring: true,
        recurrence_interval: RecurrenceInterval::MONTHLY,
        completed_at: $oneToOne->completed_at
    );

    $oneToOne = $action->execute($oneToOneData);

    $this->assertDatabaseHas('one_to_ones', [
        'person_id' => $oneToOne->person->id,
        'manager_id' => $oneToOne->manager->id,
        'requester_id' => $oneToOne->requester_id,
        'person_status' => $oneToOne->person_status,
        'manager_status' => $oneToOne->manager_status,
        'scheduled_at' => $oneToOne->scheduled_at,
        'recurring' => true,
        'recurrence_interval' => RecurrenceInterval::MONTHLY
    ]);
});
