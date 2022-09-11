<?php

use Domain\People\Models\Person;
use Domain\Performance\Actions\CreateObjectiveAction;
use Domain\Performance\Actions\UpdateObjectiveAction;
use Domain\Performance\Actions\UpdateTaskAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;

it('updates an objective', function () {
    $objective = Objective::factory()->create();
    $task = Task::factory()->create([
        'objective_id' => $objective->id
    ]);

    $action = app(UpdateTaskAction::class);
    $taskData = new TaskData(
        objective: $objective,
        description: 'A description',
        due_at: now()->addMonth(),
        completed_at: now()->addMonth()->subDay()
    );

    $this->assertModelExists($task);

    $action->execute($task, $taskData);

    $this->assertDatabaseHas('tasks', [
        'objective_id' => $taskData->objective->id,
        'description' => $taskData->description,
        'due_at' => $taskData->due_at->toDateString(),
        'completed_at' => $taskData->completed_at?->toDateString()
    ]);
});
