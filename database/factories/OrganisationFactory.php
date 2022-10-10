<?php

namespace Database\Factories;

use Domain\Organisation\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganisationFactory extends Factory
{
    protected $model = Organisation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'logo' => $this->faker->filePath(),
            'setup_at' => now()
        ];
    }
}
