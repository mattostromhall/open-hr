<?php

namespace Domain\Expenses\DataTransferObjects;

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;
use Support\Enums\Currency;

class ExpenseData extends DataTransferObject
{
    public function __construct(
        public readonly Person $person,
        public readonly ExpenseType $expense_type,
        public readonly ExpenseStatus $status,
        public readonly float $value,
        public readonly Currency $value_currency,
        public readonly Carbon $date,
        public readonly ?string $notes = null
    ) {
        //
    }
}
