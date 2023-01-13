<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CreateTaskActionInterface;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

class CreateTaskAction implements CreateTaskActionInterface
{
    public function execute(TaskData $data): Task
    {
        return Task::create([
            'objective_id' => $data->objective->id,
            'description' => $data->description,
            'due_at' => $data->due_at,
            'completed_at' => $data->completed_at
        ]);
    }
}
