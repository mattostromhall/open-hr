<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Models\Task;

class CompleteTaskAction
{
    public function execute(Task $task): bool
    {
        return $task->update([
            'completed_at' => now()
        ]);
    }
}
