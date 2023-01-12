<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;

interface CreateExpenseActionInterface
{
    public function execute(ExpenseData $data): Expense;
}
