<?php

namespace Database\Factories;

use Domain\Absences\Models\Sickness;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class SicknessFactory extends Factory
{
    protected $model = Sickness::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'start_at' => now(),
            'finish_at' => now()->addDay()
        ];
    }
}
