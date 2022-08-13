<?php

namespace Database\Factories;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OneToOneFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'manager_id' => Person::factory(),
            'status' => OneToOneStatus::INVITED,
            'scheduled_at' => now()->addMonth()
        ];
    }
}
