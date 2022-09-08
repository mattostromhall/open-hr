<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CompleteObjectiveAction;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\UpdateObjectiveAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

it('marks an objective as complete', function () {
    $person = Person::factory()->create();
    $objective = Objective::factory()->create([
        'person_id' => $person->id
    ]);

    $action = app(CompleteObjectiveAction::class);

    $this->assertModelExists($objective);

    $action->execute($objective);

    $this->assertDatabaseHas('objectives', [
        'person_id' => $objective->person_id,
        'title' => $objective->title,
        'description' => $objective->description,
        'due_at' => $objective->due_at->toDateString(),
        'completed_at' => now()->toDateString()
    ]);
});
