<?php

namespace Database\Factories;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;
use Illuminate\Database\Eloquent\Factories\Factory;

class OneToOneFactory extends Factory
{
    protected $model = OneToOne::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'manager_id' => Person::factory(),
            'person_status' => OneToOneStatus::ACCEPTED,
            'manager_status' => OneToOneStatus::INVITED,
            'scheduled_at' => now()->addMonth()
        ];
    }
}
