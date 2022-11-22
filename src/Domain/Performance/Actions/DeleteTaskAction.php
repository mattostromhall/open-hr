<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;

class DeleteTaskAction
{
    public function execute(Task $task): bool
    {
        return $task->delete();
    }
}
