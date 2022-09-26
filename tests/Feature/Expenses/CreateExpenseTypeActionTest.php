<?php

use Domain\Expenses\Actions\CreateExpenseTypeAction;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;

it('creates an expense type', function () {
    $action = app(CreateExpenseTypeAction::class);
    $expenseTypeData = new ExpenseTypeData(
        type: 'Misc'
    );

    $action->execute($expenseTypeData);

    $this->assertDatabaseHas('expense_types', [
        'type' => $expenseTypeData->type
    ]);
});
