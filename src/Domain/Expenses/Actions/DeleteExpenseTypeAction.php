<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Models\ExpenseType;

class DeleteExpenseTypeAction
{
    public function execute(ExpenseType $expenseType): bool
    {
        return $expenseType->delete();
    }
}
