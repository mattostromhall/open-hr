<?php

namespace Database\Factories;

use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveFactory extends Factory
{
    protected $model = Objective::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'title' => $this->faker->text(20),
            'description' => $this->faker->text(),
            'due_at' => now()->addMonth()
        ];
    }
}
