<?php

namespace Database\Factories;

use Domain\Auth\Models\User;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\Currency;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->title(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'initials' => $this->faker->randomLetter(),
            'pronouns' => 'He/Him',
            'dob' => $this->faker->date(),
            'position' => $this->faker->jobTitle(),
            'remuneration' => $this->faker->numberBetween(0, 100000),
            'remuneration_interval' => RemunerationInterval::MONTHLY,
            'remuneration_currency' => Currency::GBP,
            'base_holiday_allocation' => 25,
            'holiday_carry_allocation' => 5,
            'holiday_carried' => 0,
            'sickness_allocation' => 10,
            'contact_number' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->companyEmail(),
            'started_on' => $this->faker->date()
        ];
    }
}
