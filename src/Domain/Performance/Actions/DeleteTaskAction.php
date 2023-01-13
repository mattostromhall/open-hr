<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\DeleteTaskActionInterface;
use Domain\Performance\Models\Task;

class DeleteTaskAction implements DeleteTaskActionInterface
{
    public function execute(Task $task): bool
    {
        return $task->delete();
    }
}
