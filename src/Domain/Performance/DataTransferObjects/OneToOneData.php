<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;

class OneToOneData
{
    public function __construct(
        public readonly Person $person,
        public readonly Person $manager,
        public readonly OneToOneStatus $status,
        public readonly string $scheduled_at,
        public readonly bool $recurring,
        public readonly ?RecurrenceInterval $recurrence_interval = null,
        public readonly ?string $completed_at = null,
        public readonly ?string $notes = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
