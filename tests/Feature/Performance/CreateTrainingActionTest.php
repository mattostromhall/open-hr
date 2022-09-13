<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;

it('creates training', function () {
    $person = Person::factory()->create();

    $action = app(CreateTrainingAction::class);
    $trainingData = new TrainingData(
        person: $person,
        status: TrainingStatus::PENDING,
        state: TrainingState::TODO,
        provider: 'Laracasts',
        description: 'A description'
    );

    $action->execute($trainingData);

    $this->assertDatabaseHas('training', [
        'person_id' => $trainingData->person->id,
        'status' => $trainingData->status,
        'state' => $trainingData->state,
        'provider' => $trainingData->provider,
        'description' => $trainingData->description
    ]);
});
