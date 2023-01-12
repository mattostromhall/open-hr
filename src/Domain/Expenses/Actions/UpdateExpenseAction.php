<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\UpdateExpenseActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;

class UpdateExpenseAction implements UpdateExpenseActionInterface
{
    public function execute(Expense $expense, ExpenseData $data): bool
    {
        return $expense->update([
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
