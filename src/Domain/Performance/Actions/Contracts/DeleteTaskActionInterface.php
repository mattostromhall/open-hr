<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\Task;

interface DeleteTaskActionInterface
{
    public function execute(Task $task): bool;
}
