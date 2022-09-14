<?php

namespace Database\Factories;

use Domain\People\Models\Person;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\Currency;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'status' => TrainingStatus::PENDING,
            'state' => TrainingState::TODO,
            'description' => $this->faker->text(100),
            'provider' => $this->faker->text(20),
            'location' => $this->faker->address(),
            'cost' => $this->faker->numberBetween(10, 100),
            'cost_currency' => Currency::GBP
        ];
    }
}
