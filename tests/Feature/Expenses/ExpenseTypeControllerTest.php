<?php

use Domain\Expenses\Models\ExpenseType;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the expense type index', function () {
    ExpenseType::factory()->count(3)->create();

    $this->get(route('expense-type.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Expenses/ExpenseTypes/Index')
                ->has('expenseTypes.data', 3)
        );
});

it('returns the expense type create page', function () {
    ExpenseType::factory()->count(3)->create();

    $this->get(route('expense-type.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page->component('Expenses/ExpenseTypes/Create')
        );
});

it('creates a new expense type when the correct data is provided', function () {
    $response = $this->post(route('expense-type.store'), [
        'type' => 'Misc'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Expense Type created!');
});

it('returns validation errors when creating an expense type with incorrect data', function () {
    $expenseType = ExpenseType::factory()->create();

    $response = $this->post(route('expense-type.store'), [
        'type' => $expenseType->type
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['type']);
});

it('returns the expense type to edit', function () {
    $expenseType = ExpenseType::factory()->create();

    $this->get(route('expense-type.edit', ['expense_type' => $expenseType]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Expenses/ExpenseTypes/Edit')
                ->hasAll('expenseType')
        );
});

it('updates the expense type when the correct data is provided', function () {
    $expenseType = ExpenseType::factory()->create();

    $response = $this->put(route('expense-type.update', ['expense_type' => $expenseType]), [
        'type' => 'Miscellaneous'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Expense Type updated!');
});

it('returns validation errors when updating the expense type with incorrect data', function () {
    $expenseType = ExpenseType::factory()->create();

    $response = $this->put(route('expense-type.update', ['expense_type' => $expenseType]), [
        'type' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['type']);
});
