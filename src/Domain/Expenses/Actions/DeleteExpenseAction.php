<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\DeleteExpenseActionInterface;
use Domain\Expenses\Models\Expense;

class DeleteExpenseAction implements DeleteExpenseActionInterface
{
    public function execute(Expense $expense): bool
    {
        return $expense->delete();
    }
}
