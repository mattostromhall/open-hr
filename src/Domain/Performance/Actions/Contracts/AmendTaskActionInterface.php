<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

interface AmendTaskActionInterface
{
    public function execute(Task $task, TaskData $data): bool;
}
