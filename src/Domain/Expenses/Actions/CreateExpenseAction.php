<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\CreateExpenseActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;

class CreateExpenseAction implements CreateExpenseActionInterface
{
    public function execute(ExpenseData $data): Expense
    {
        return Expense::create([
            'person_id' => $data->person->id,
            'expense_type_id' => $data->expense_type->id,
            'status' => $data->status,
            'value' => $data->value,
            'value_currency' => $data->value_currency,
            'date' => $data->date,
            'notes' => $data->notes
        ]);
    }
}
