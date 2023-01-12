<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\DeleteExpenseTypeActionInterface;
use Domain\Expenses\Models\ExpenseType;

class DeleteExpenseTypeAction implements DeleteExpenseTypeActionInterface
{
    public function execute(ExpenseType $expenseType): bool
    {
        return $expenseType->delete();
    }
}
