<?php

namespace Domain\People\DataTransferObjects;

use Domain\Organisation\Models\Department;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;
use Support\Enums\Currency;

class PersonProfileData extends DataTransferObject
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
}
