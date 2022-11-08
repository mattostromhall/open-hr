<?php

namespace Domain\Recruitment\DataTransferObjects;

use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;
use Support\Enums\Currency;

class VacancyData extends DataTransferObject
{
    public function __construct(
        public readonly Person $contact,
        public readonly string $public_id,
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
}
