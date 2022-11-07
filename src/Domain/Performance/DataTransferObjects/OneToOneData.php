<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;

class OneToOneData extends DataTransferObject
{
    public function __construct(
        public readonly Person $person,
        public readonly Person $manager,
        public readonly int $requester_id,
        public readonly OneToOneStatus $person_status,
        public readonly OneToOneStatus $manager_status,
        public readonly Carbon $scheduled_at,
        public readonly bool $recurring = false,
        public readonly RecurrenceInterval $recurrence_interval = RecurrenceInterval::NEVER,
        public readonly ?Carbon $completed_at = null,
        public readonly ?string $notes = null
    ) {
        //
    }
}
