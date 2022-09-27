<?php

use Domain\Expenses\Actions\UpdateExpenseTypeAction;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

it('updates an expense type', function () {
    $expenseType = ExpenseType::factory()->create();

    $action = app(UpdateExpenseTypeAction::class);
    $expenseTypeData = new ExpenseTypeData(
        type: 'Misc'
    );

    $this->assertModelExists($expenseType);

    $action->execute($expenseType, $expenseTypeData);

    $this->assertDatabaseHas('expense_types', [
        'type' => $expenseTypeData->type
    ]);
});
