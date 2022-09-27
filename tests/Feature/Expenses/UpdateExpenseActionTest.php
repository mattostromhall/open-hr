<?php

use Domain\Expenses\Actions\UpdateExpenseAction;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\Expense;
use Domain\Expenses\Models\ExpenseType;

it('updates an expense', function () {
    $expense = Expense::factory()->create();
    $expenseType = ExpenseType::factory()->create();

    $action = app(UpdateExpenseAction::class);
    $expenseData = new ExpenseData(
        person: $expense->person,
        type: $expenseType,
        status: ExpenseStatus::APPROVED,
        value: $expense->value,
        date: $expense->date
    );

    $this->assertModelExists($expense);

    $action->execute($expense, $expenseData);

    $this->assertDatabaseHas('expenses', [
        'person_id' => $expenseData->person->id,
        'expense_type_id' => $expenseData->type->id,
        'status' => $expenseData->status,
        'value' => $expenseData->value,
        'date' => $expenseData->date->toDateString()
    ]);
});
