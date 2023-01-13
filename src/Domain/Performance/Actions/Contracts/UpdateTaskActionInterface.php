<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

interface UpdateTaskActionInterface
{
    public function execute(Task $task, TaskData $data): bool;
}
