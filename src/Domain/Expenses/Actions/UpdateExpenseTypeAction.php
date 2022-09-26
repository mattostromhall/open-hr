<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

class UpdateExpenseTypeAction
{
    public function execute(ExpenseType $expenseType, ExpenseTypeData $data): bool
    {
        return $expenseType->update([
            'type' => $data->type
        ]);
    }
}
