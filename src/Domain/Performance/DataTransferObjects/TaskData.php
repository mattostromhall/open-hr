<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\Performance\Models\Objective;

class TaskData
{
    public function __construct(
        public readonly Objective $objective,
        public readonly string $description,
        public readonly string $due_at,
        public readonly string $completed_at
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
