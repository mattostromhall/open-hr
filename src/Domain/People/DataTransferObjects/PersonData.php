<?php

namespace Domain\People\DataTransferObjects;

use Domain\Organisation\Models\Department;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;
use Support\Enums\Currency;

class PersonData
{
    public function __construct(
        public readonly User $user,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly Carbon $dob,
        public readonly string $position,
        public readonly int $remuneration,
        public readonly RemunerationInterval $remuneration_interval,
        public readonly Currency $remuneration_currency,
        public readonly int $base_holiday_allocation,
        public readonly int $sickness_allocation,
        public readonly string $contact_number,
        public readonly string $contact_email,
        public readonly Carbon $started_on,
        public readonly ?Person $manager = null,
        public readonly ?Department $department = null,
        public readonly ?string $title = null,
        public readonly ?string $initials = null,
        public readonly ?string $pronouns = null,
        public readonly ?Carbon $finished_on = null,
        public readonly int $holiday_carry_allocation = 0,
        public readonly int $holiday_carried = 0,
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
