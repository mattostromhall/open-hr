<?php

use Domain\Performance\Actions\DeleteObjectiveAction;
use Domain\Performance\Models\Objective;

it('deletes the objective', function () {
    $objective = Objective::factory()->create();
    $action = app(DeleteObjectiveAction::class);

    $this->assertNotSoftDeleted($objective);

    $action->execute($objective);

    $this->assertSoftDeleted($objective);
});
