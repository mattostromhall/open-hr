<?php

namespace Database\Factories;

use Domain\Absences\Models\Sickness;
use Illuminate\Database\Eloquent\Factories\Factory;

class SicknessFactory extends Factory
{
    protected $model = Sickness::class;

    public function definition(): array
    {
        return [
            'start_at' => now(),
            'finish_at' => now()->addDay()
        ];
    }
}
