<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;

it('creates an objective', function () {
    $person = Person::factory()->create();

    $action = app(CreateObjectiveAction::class);
    $objectiveData = new ObjectiveData(
        person: $person,
        title: 'A title',
        description: 'A description',
        due_at: now()->addMonth()
    );

    $action->execute($objectiveData);

    $this->assertDatabaseHas('objectives', [
        'person_id' => $objectiveData->person->id,
        'title' => $objectiveData->title,
        'description' => $objectiveData->description,
        'due_at' => $objectiveData->due_at->toDateString()
    ]);
});
