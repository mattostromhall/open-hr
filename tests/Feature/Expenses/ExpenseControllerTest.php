<?php

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\Expense;
use Domain\Expenses\Models\ExpenseType;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;
use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the expense index', function () {
    Expense::factory()->for($this->person)->create();
    Expense::factory()->for($this->person)->create(['status' => ExpenseStatus::APPROVED]);
    Expense::factory()->for($this->person)->create(['status' => ExpenseStatus::REJECTED]);

    $this->get(route('expense.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Expenses/Index')
                ->where('active', 'submit')
                ->has('expenseTypes', 3)
                ->has('pending', 1)
                ->has('approved', 1)
                ->has('rejected', 1)
                ->hasAll([
                    'pending.0.id',
                    'pending.0.type',
                    'pending.0.expense_type_id',
                    'pending.0.status',
                    'pending.0.value',
                    'pending.0.notes',
                    'pending.0.created_at',
                    'approved.0.id',
                    'approved.0.type',
                    'approved.0.expense_type_id',
                    'approved.0.status',
                    'approved.0.value',
                    'approved.0.notes',
                    'approved.0.created_at',
                    'rejected.0.id',
                    'rejected.0.type',
                    'rejected.0.expense_type_id',
                    'rejected.0.status',
                    'rejected.0.value',
                    'rejected.0.notes',
                    'rejected.0.created_at'
                ])
        );
});

it('submits an expense when the correct data is provided', function () {
    $expenseType = ExpenseType::factory()->create();

    $response = $this->post(route('expense.store'), [
        'person_id' => $this->person->id,
        'expense_type_id' => $expenseType->id,
        'status' => ExpenseStatus::PENDING->value,
        'value' => 10,
        'value_currency' => Currency::GBP->value,
        'date' => now()->subDays(3),
        'documents' => [UploadedFile::fake()->create('document.pdf', 10)]
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Expense submitted!');
});

it('returns validation errors when submitting an expense with incorrect data', function () {
    $response = $this->post(route('expense.store'), [
        'person_id' => null,
        'expense_type_id' => null,
        'status' => null,
        'value' => null,
        'value_currency' => null,
        'date' => null,
        'documents' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_id', 'expense_type_id', 'status', 'value', 'value_currency', 'date', 'documents']);
});

it('shows the expense', function () {
    $expense = Expense::factory()->create();

    $this->get(route('expense.show', ['expense' => $expense]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Expenses/Show')
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

it('returns the expense to edit', function () {
    $expense = Expense::factory()->create();

    $this->get(route('expense.edit', ['expense' => $expense]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Expenses/Edit')
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

it('updates the expense when the correct data is provided', function () {
    $expense = Expense::factory()->create();

    $response = $this->put(route('expense.update', ['expense' => $expense]), [
        'expense_type_id' => $expense->type->id,
        'status' => ExpenseStatus::APPROVED->value,
        'value' => 15,
        'value_currency' => Currency::GBP->value,
        'date' => now()->subDays(3)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Expense updated!');
});

it('returns validation errors when updating the expense with incorrect data', function () {
    $expense = Expense::factory()->create();

    $response = $this->put(route('expense.update', ['expense' => $expense]), [
        'expense_type_id' => null,
        'status' => null,
        'value' => null,
        'value_currency' => null,
        'date' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['expense_type_id', 'status', 'value', 'value_currency', 'date']);
});

it('deletes the expense submission', function () {
    $expense = Expense::factory()->create();

    $response = $this->delete(route('expense.destroy', ['expense' => $expense]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Expense withdrawn!');
});
