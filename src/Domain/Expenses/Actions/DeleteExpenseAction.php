<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Models\Expense;

class DeleteExpenseAction
{
    public function execute(Expense $expense): bool
    {
        return $expense->delete();
    }
}
