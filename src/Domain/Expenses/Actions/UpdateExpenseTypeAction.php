<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\UpdateExpenseTypeActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

class UpdateExpenseTypeAction implements UpdateExpenseTypeActionInterface
{
    public function execute(ExpenseType $expenseType, ExpenseTypeData $data): bool
    {
        return $expenseType->update([
            'type' => $data->type
        ]);
    }
}
