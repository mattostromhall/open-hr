<?php

namespace Domain\Recruitment\DataTransferObjects;

use Illuminate\Support\Carbon;

class VacancyData
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $contract_type,
        public readonly int $remuneration,
        public readonly string $contact,
        public readonly Carbon $open_at,
        public readonly ?string $contract_length = null,
        public readonly ?Carbon $close_at = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
