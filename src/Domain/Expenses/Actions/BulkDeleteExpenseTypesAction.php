<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\BulkDeleteExpenseTypesActionInterface;
use Domain\Expenses\Models\ExpenseType;

class BulkDeleteExpenseTypesAction implements BulkDeleteExpenseTypesActionInterface
{
    /**
     * @param array<int> $expenseTypes
     * @return bool
     */
    public function execute(array $expenseTypes): bool
    {
        return ExpenseType::query()
            ->whereIn('id', $expenseTypes)
            ->delete();
    }
}
