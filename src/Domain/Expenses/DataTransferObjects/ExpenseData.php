<?php

namespace Domain\Expenses\DataTransferObjects;

use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;

class ExpenseData
{
    public function __construct(
        public readonly Person $person,
        public readonly ExpenseType $type,
        public readonly int $value,
        public readonly string $date,
        public readonly ?string $notes
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
