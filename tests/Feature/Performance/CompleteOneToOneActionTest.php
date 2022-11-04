<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CompleteObjectiveAction;
use Domain\Performance\Actions\CompleteOneToOneAction;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\UpdateObjectiveAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\OneToOne;

it('marks a one-to-one as complete', function () {
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

    $action = app(CompleteOneToOneAction::class);

    $this->assertModelExists($oneToOne);

    $action->execute($oneToOne);

    $this->assertDatabaseHas('one_to_ones', [
        'person_id' => $oneToOne->person->id,
        'manager_id' => $oneToOne->manager->id,
        'requester_id' => $oneToOne->person->id,
        'person_status' => OneToOneStatus::ACCEPTED,
        'manager_status' => OneToOneStatus::ACCEPTED,
        'scheduled_at' => $oneToOne->scheduled_at->toDateTimeString()
    ]);
});
