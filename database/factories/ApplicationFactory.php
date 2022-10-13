<?php

namespace Database\Factories;

use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'vacancy_id' => Vacancy::factory(),
            'status' => ApplicationStatus::PENDING,
            'name' => $this->faker->name(),
            'contact_number' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->email(),
            'cover_letter' => $this->faker->randomHtml()
        ];
    }
}
