<?php

namespace Domain\People\DataTransferObjects;

use Domain\Auth\DataTransferObjects\UserData;
use Domain\Organisation\Models\Department;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;
use Support\Enums\Currency;

class PersonUserData extends DataTransferObject
{
    public function __construct(
        public readonly UserData $user_data,
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
        public readonly ?int $holiday_carry_allocation = 0,
        public readonly ?int $holiday_carried = 0
    ) {
        //
    }
}
