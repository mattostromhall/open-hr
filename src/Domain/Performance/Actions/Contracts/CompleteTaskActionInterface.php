<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\Task;

interface CompleteTaskActionInterface
{
    public function execute(Task $task): bool;
}
