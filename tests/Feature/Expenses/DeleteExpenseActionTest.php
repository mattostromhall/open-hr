<?php

use Domain\Expenses\Actions\DeleteExpenseAction;
use Domain\Expenses\Models\Expense;

it('deletes the expense', function () {
    $expense = Expense::factory()->create();

    $action = app(DeleteExpenseAction::class);

    $this->assertNotSoftDeleted($expense);

    $action->execute($expense);

    $this->assertSoftDeleted($expense);
});
