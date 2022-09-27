<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;

class UpdateExpenseAction
{
    public function execute(Expense $expense, ExpenseData $data): bool
    {
        return $expense->update([
            'person_id' => $data->person->id,
            'expense_type_id' => $data->type->id,
            'status' => $data->status,
            'value' => $data->value,
            'date' => $data->date,
            'notes' => $data->notes
        ]);
    }
}
