<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\CreateTaskAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;

it('creates a task', function () {
    $objective = Objective::factory()->create();

    $action = app(CreateTaskAction::class);
    $taskData = new TaskData(
        objective: $objective,
        description: 'A description',
        due_at: now()->addMonth()
    );

    $action->execute($taskData);

    $this->assertDatabaseHas('tasks', [
        'objective_id' => $taskData->objective->id,
        'description' => $taskData->description,
        'due_at' => $taskData->due_at->toDateString()
    ]);
});
