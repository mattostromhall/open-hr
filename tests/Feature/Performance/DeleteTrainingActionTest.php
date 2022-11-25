<?php

use Domain\Performance\Actions\DeleteTrainingAction;
use Domain\Performance\Models\Training;

it('deletes the training', function () {
    $training = Training::factory()->create();

    $action = app(DeleteTrainingAction::class);

    $this->assertNotSoftDeleted($training);

    $action->execute($training);

    $this->assertSoftDeleted($training);
});
