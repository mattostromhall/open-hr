<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\UpdateTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Training;

it('updates the training', function () {
    $person = Person::factory()->create();
    $training = Training::factory()->create([
        'person_id' => $person->id
    ]);

    $action = app(UpdateTrainingAction::class);
    $trainingData = new TrainingData(
        person: $person,
        status: TrainingStatus::APPROVED,
        state: TrainingState::TODO,
        provider: 'Laracasts',
        description: 'A description'
    );

    $this->assertModelExists($training);

    $action->execute($training, $trainingData);

    $this->assertDatabaseHas('training', [
        'person_id' => $trainingData->person->id,
        'status' => $trainingData->status,
        'state' => $trainingData->state,
        'description' => $trainingData->description,
        'provider' => $trainingData->provider
    ]);
});
