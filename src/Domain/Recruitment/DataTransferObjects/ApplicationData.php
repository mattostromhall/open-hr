<?php

namespace Domain\Recruitment\DataTransferObjects;

use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Vacancy;

class ApplicationData
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

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
