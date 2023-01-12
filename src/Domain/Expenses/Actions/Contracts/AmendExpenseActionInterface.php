<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\DataTransferObjects\SubmittedExpenseData;
use Domain\Expenses\Models\Expense;

interface AmendExpenseActionInterface
{
    public function execute(Expense $expense, SubmittedExpenseData $data): bool;
}
