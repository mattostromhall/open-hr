<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\DeleteTrainingAction;
use Domain\Performance\Actions\UpdateObjectiveAction;
use Domain\Performance\Actions\UpdateTrainingAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Training;

it('deletes the training', function () {
    $training = Training::factory()->create();

    $action = app(DeleteTrainingAction::class);

    $this->assertNotSoftDeleted($training);

    $action->execute($training);

    $this->assertSoftDeleted($training);
});
