<?php

use Domain\Expenses\Actions\CreateExpenseTypeAction;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

it('updates an expense type', function () {
    $expenseType = ExpenseType::factory()->create();

    $action = app(CreateExpenseTypeAction::class);
    $expenseTypeData = new ExpenseTypeData(
        type: 'Misc'
    );

    $this->assertModelExists($expenseType);

    $action->execute($expenseTypeData);

    $this->assertDatabaseHas('expense_types', [
        'type' => $expenseTypeData->type
    ]);
});
