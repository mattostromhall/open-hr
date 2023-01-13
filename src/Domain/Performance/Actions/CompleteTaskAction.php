<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CompleteTaskActionInterface;
use Domain\Performance\Models\Task;

class CompleteTaskAction implements CompleteTaskActionInterface
{
    public function execute(Task $task): bool
    {
        return $task->update([
            'completed_at' => now()
        ]);
    }
}
