<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CompleteTrainingAction;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Models\Training;

it('marks training as complete', function () {
    $manager = Person::factory()->create();
    $person = Person::factory()->create([
        'manager_id' => $manager->id
    ]);
    $training = Training::factory()->create([
        'person_id' => $person->id
    ]);

    $action = app(CompleteTrainingAction::class);

    $this->assertModelExists($training);

    $action->execute($training);

    $this->assertDatabaseHas('training', [
        'person_id' => $training->person_id,
        'description' => $training->description,
        'provider' => $training->provider,
        'status' => $training->status,
        'state' => TrainingState::COMPLETED
    ]);
});
