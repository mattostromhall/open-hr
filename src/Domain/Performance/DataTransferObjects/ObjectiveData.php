<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;
use Illuminate\Support\Carbon;

class ObjectiveData
{
    public function __construct(
        public readonly Person $person,
        public readonly string $title,
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
