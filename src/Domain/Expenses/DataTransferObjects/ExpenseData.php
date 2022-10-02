<?php

namespace Domain\Expenses\DataTransferObjects;

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Illuminate\Support\Carbon;
use Support\Enums\Currency;

class ExpenseData
{
    public function __construct(
        public readonly Person $person,
        public readonly ExpenseType $type,
        public readonly ExpenseStatus $status,
        public readonly float $value,
        public readonly Currency $value_currency,
        public readonly Carbon $date,
        public readonly ?string $notes = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
