<?php

namespace Database\Factories;

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\Expense;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'expense_type_id' => ExpenseType::factory(),
            'status' => ExpenseStatus::PENDING,
            'value' => 9.50,
            'date' => now()
        ];
    }
}
