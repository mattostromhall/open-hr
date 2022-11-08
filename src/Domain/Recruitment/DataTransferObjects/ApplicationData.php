<?php

namespace Domain\Recruitment\DataTransferObjects;

use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Vacancy;
use Support\DataTransferObjects\DataTransferObject;

class ApplicationData extends DataTransferObject
{
    public function __construct(
        public readonly Vacancy $vacancy,
        public readonly ApplicationStatus $status,
        public readonly string $name,
        public readonly string $contact_number,
        public readonly string $contact_email,
        public readonly ?string $cover_letter = null
    ) {
        //
    }
}
