<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

interface CreateTaskActionInterface
{
    public function execute(TaskData $data): Task;
}
