<?php

namespace Database\Factories;

use Domain\People\Models\Address;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'address_line' => $this->faker->streetAddress(),
            'town_city' => $this->faker->city(),
            'region' => 'Region',
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->postcode()
        ];
    }
}
