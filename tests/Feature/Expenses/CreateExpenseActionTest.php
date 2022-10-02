<?php

use Domain\Expenses\Actions\CreateExpenseAction;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Support\Enums\Currency;

it('creates an expense', function () {
    $person = Person::factory()->create();
    $expenseType = ExpenseType::factory()->create();

    $action = app(CreateExpenseAction::class);
    $expenseData = new ExpenseData(
        person: $person,
        type: $expenseType,
        status: ExpenseStatus::PENDING,
        value: 9.50,
        value_currency: Currency::GBP,
        date: now()
    );

    $action->execute($expenseData);

    $this->assertDatabaseHas('expenses', [
        'person_id' => $expenseData->person->id,
        'expense_type_id' => $expenseData->type->id,
        'status' => $expenseData->status,
        'value' => $expenseData->value,
        'value_currency' => Currency::GBP,
        'date' => $expenseData->date->toDateString()
    ]);
});
