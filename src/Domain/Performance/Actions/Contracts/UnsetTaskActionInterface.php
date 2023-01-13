<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

interface UnsetTaskActionInterface
{
    public function execute(Task $task, TaskData $data): bool;
}
