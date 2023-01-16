<?php

use Domain\Auth\Enums\Role;
use Domain\Expenses\Models\ExpenseType;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('bulk deletes the selected expense types', function () {
    $this->person->assign(Role::ADMIN);
    $expenseTypes = ExpenseType::factory()->count(3)->create();

    $response = $this->post(route('expense-type.bulk-delete'), [
        'expenseTypes' => $expenseTypes->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success',  'Selected Expense Types deleted!');
});

it('returns unauthorized if the person does not have permission to bulk delete expense types', function () {
    $expenseTypes = ExpenseType::factory()->count(3)->create();

    $response = $this->post(route('expense-type.bulk-delete'), [
        'expenseTypes' => $expenseTypes->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});
