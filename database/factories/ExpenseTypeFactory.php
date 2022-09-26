<?php

namespace Database\Factories;

use Domain\Expenses\Models\ExpenseType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseTypeFactory extends Factory
{
    protected $model = ExpenseType::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->text(25)
        ];
    }
}
