<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;

class CreateExpenseAction
{
    public function execute(ExpenseData $data): Expense
    {
        return Expense::create([
            'person_id' => $data->person->id,
            'expense_type_id' => $data->type->id,
            'status' => $data->status,
            'value' => $data->value,
            'date' => $data->date,
            'notes' => $data->notes
        ]);
    }
}
