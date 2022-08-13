<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Support\Carbon;

class OneToOneData
{
    public function __construct(
        public readonly Person $person,
        public readonly Person $manager,
        public readonly OneToOneStatus $status,
        public readonly Carbon $scheduled_at,
        public readonly bool $recurring = false,
        public readonly ?RecurrenceInterval $recurrence_interval = null,
        public readonly ?Carbon $completed_at = null,
        public readonly ?string $notes = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
