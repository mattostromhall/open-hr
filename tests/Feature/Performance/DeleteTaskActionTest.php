<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\DeleteTaskAction;
use Domain\Performance\Actions\UpdateObjectiveAction;
use Domain\Performance\Actions\UpdateTaskAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;

it('deletes the task', function () {
    $task = Task::factory()->create();

    $action = app(DeleteTaskAction::class);

    $this->assertNotSoftDeleted($task);

    $action->execute($task);

    $this->assertSoftDeleted($task);
});
