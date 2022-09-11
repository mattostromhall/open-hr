<?php

namespace Database\Factories;

use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'objective_id' => Objective::factory(),
            'description' => $this->faker->text(),
            'due_at' => now()->addMonth()
        ];
    }
}
