<?php

use Domain\Expenses\Actions\BulkDeleteExpenseTypesAction;
use Domain\Expenses\Models\ExpenseType;

it('bulk deletes the expense types', function () {
    $expenseTypes = ExpenseType::factory()->count(3)->create();
    $action = app(BulkDeleteExpenseTypesAction::class);

    $expenseTypes->each(fn (ExpenseType $expenseType) => $this->assertNotSoftDeleted($expenseType));

    $action->execute($expenseTypes->pluck('id')->toArray());

    $expenseTypes->each(fn (ExpenseType $expenseType) => $this->assertSoftDeleted($expenseType));
});
