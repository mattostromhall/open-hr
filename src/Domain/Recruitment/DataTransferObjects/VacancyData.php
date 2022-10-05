<?php

namespace Domain\Recruitment\DataTransferObjects;

use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Illuminate\Support\Carbon;
use Support\Enums\Currency;

class VacancyData
{
    public function __construct(
        public readonly Person $contact,
        public readonly string $title,
        public readonly string $description,
        public readonly string $location,
        public readonly ContractType $contract_type,
        public readonly int $remuneration,
        public readonly Currency $remuneration_currency,
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
