<?php

namespace Database\Factories;

use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\Currency;

class VacancyFactory extends Factory
{
    protected $model = Vacancy::class;

    public function definition(): array
    {
        return [
            'contact_id' => Person::factory(),
            'public_id' => $this->faker->uuid(),
            'title' => $this->faker->text(20),
            'description' => $this->faker->randomHtml(),
            'location' => $this->faker->country(),
            'contract_type' => ContractType::FULL_TIME,
            'remuneration' => $this->faker->randomNumber(5),
            'remuneration_currency' => Currency::GBP,
            'open_at' => now()
        ];
    }
}
