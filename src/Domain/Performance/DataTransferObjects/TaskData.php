<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\Performance\Models\Objective;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;

class TaskData extends DataTransferObject
{
    public function __construct(
        public readonly Objective $objective,
        public readonly string $description,
        public readonly Carbon $due_at,
        public readonly ?Carbon $completed_at = null
    ) {
        //
    }
}
