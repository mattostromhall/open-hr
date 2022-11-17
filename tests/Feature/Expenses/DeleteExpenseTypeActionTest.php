<?php

use Domain\Expenses\Actions\DeleteExpenseTypeAction;
use Domain\Expenses\Models\ExpenseType;

it('deletes the expense type', function () {
    $expenseType = ExpenseType::factory()->create();

    $action = app(DeleteExpenseTypeAction::class);

    $this->assertNotSoftDeleted($expenseType);

    $action->execute($expenseType);

    $this->assertSoftDeleted($expenseType);
});
