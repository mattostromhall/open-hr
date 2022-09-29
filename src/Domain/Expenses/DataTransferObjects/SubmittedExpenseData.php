<?php

namespace Domain\Expenses\DataTransferObjects;

use Illuminate\Support\Collection;

class SubmittedExpenseData
{
    public function __construct(
        public readonly ExpenseData $expense_data,
        public readonly Collection $documents
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
