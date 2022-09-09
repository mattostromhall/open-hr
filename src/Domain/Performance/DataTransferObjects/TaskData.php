<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\Performance\Models\Objective;
use Illuminate\Support\Carbon;

class TaskData
{
    public function __construct(
        public readonly Objective $objective,
        public readonly string $description,
        public readonly Carbon $due_at,
        public readonly ?Carbon $completed_at = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
