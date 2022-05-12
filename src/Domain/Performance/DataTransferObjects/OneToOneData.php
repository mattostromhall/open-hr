<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;

class OneToOneData
{
    public function __construct(
        public readonly Person $person,
        public readonly Person $manager,
        public readonly string $scheduled_at,
        public readonly string $completed_at,
        public readonly bool $recurring
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
