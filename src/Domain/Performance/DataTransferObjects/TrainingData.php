<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;

class TrainingData
{
    public function __construct(
        public readonly Person $person,
        public readonly int $status,
        public readonly int $progress,
        public readonly string $provider,
        public readonly ?string $location,
        public readonly ?int $cost,
        public readonly ?int $duration,
        public readonly ?string $notes
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
