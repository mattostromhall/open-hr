<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;

interface RequestExpenseReviewActionInterface
{
    public function execute(Expense $expense, ExpenseData $data): void;
}
