<?php

namespace Domain\People\DataTransferObjects;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;
use Domain\Organisation\Models\Department;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;

class PersonData
{
    public function __construct(
        public readonly User $user,
        public readonly ?Person $manager,
        public readonly ?Department $department,
        public readonly ?string $title,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly ?string $initials,
        public readonly string $pronouns,
        public readonly string $dob,
        public readonly string $position,
        public readonly int $remuneration,
        public readonly RemunerationInterval $remuneration_interval,
        public readonly int $holiday_allocation,
        public readonly int $sickness_allocation,
        public readonly string $contact_number,
        public readonly string $contact_email,
        public readonly Carbon $started_on,
        public readonly ?Carbon $finished_on = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
