<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;

class ObjectiveData
{
    public function __construct(
        public readonly Person $person,
        public readonly string $title,
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
