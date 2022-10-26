<?php

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\Expense;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('shows the expense to review', function () {
    $expense = Expense::factory()->create();

    $this->get(route('expense.review.show', ['expense' => $expense]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Expenses/Review')
                ->hasAll([
                    'expense',
                    'type',
                    'requester',
                    'status',
                    'expenseTypes',
                    'documents'
                ])
        );
});

it('reviews the expense when the correct data is provided', function () {
    $expense = Expense::factory()->create();

    $response = $this->patch(route('expense.review.update', ['expense' => $expense]), [
        'expense_type_id' => $expense->type->id,
        'status' => ExpenseStatus::APPROVED->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Expense ' . ExpenseStatus::APPROVED->statusDisplay() . '.');
});

it('returns validation errors when reviewing the expense with incorrect data', function () {
    $expense = Expense::factory()->create();

    $response = $this->patch(route('expense.review.update', ['expense' => $expense]), [
        'expense_type_id' => null,
        'status' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['expense_type_id', 'status']);
});
