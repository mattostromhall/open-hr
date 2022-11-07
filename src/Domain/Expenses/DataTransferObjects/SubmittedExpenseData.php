<?php

namespace Domain\Expenses\DataTransferObjects;

use Illuminate\Support\Collection;
use Support\DataTransferObjects\DataTransferObject;

class SubmittedExpenseData extends DataTransferObject
{
    public function __construct(
        public readonly ExpenseData $expense_data,
        public readonly Collection $documents
    ) {
        //
    }
}
