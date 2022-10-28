<?php

namespace Domain\People\DataTransferObjects;

use Domain\Organisation\Models\Department;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;
use Support\Enums\Currency;

class PersonProfileData
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly Carbon $dob,
        public readonly string $contact_number,
        public readonly string $contact_email,
        public readonly ?string $title = null,
        public readonly ?string $initials = null,
        public readonly ?string $pronouns = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
