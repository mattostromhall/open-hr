<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;

class UpdateTaskAction
{
    public function execute(Task $task, TaskData $data): bool
    {
        return $task->update([
            'objective_id' => $data->objective->id,
            'description' => $data->description,
            'due_at' => $data->due_at,
            'completed_at' => $data->completed_at
        ]);
    }
}
