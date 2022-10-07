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
        public readonly ?string $location = null,
        public readonly ?ContractType $contract_type = null,
        public readonly ?string $contract_length = null,
        public readonly ?int $remuneration = null,
        public readonly ?Currency $remuneration_currency = null,
        public readonly ?Carbon $open_at = null,
        public readonly ?Carbon $close_at = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
