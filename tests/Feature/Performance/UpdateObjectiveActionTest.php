<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\UpdateObjectiveAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

it('updates an objective', function () {
    $person = Person::factory()->create();
    $objective = Objective::factory()->create([
        'person_id' => $person->id
    ]);

    $action = app(UpdateObjectiveAction::class);
    $objectiveData = new ObjectiveData(
        person: $person,
        title: 'A title',
        description: 'A description',
        due_at: now()->addMonth(),
        completed_at: now()->addMonth()->subDay()
    );

    $this->assertModelExists($objective);

    $action->execute($objective, $objectiveData);

    $this->assertDatabaseHas('objectives', [
        'person_id' => $objectiveData->person->id,
        'title' => $objectiveData->title,
        'description' => $objectiveData->description,
        'due_at' => $objectiveData->due_at->toDateString(),
        'completed_at' => $objectiveData->completed_at->toDateString()
    ]);
});
