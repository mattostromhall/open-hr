<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\Models\ExpenseType;

interface DeleteExpenseTypeActionInterface
{
    public function execute(ExpenseType $expenseType): bool;
}
