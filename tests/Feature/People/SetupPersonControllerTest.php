<?php

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Organisation;
use Domain\People\Enums\RemunerationInterval;

use function Pest\Faker\fake;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create([
        'setup_at' => null
    ]);
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('creates a new person when the correct data is provided', function () {
    $response = $this->post(route('setup.person'), [
        'user_id' => $this->user->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => now()->subYears(30),
        'position' => fake()->jobTitle(),
        'remuneration' => fake()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => fake()->phoneNumber(),
        'contact_email' => fake()->email(),
        'started_on' => now()->subYear()
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('dashboard'));
});

it('returns validation errors when creating a new person with incorrect data', function () {
    $response = $this->post(route('setup.person'), [
        'user_id' => null,
        'first_name' => null,
        'last_name' => null,
        'dob' => null,
        'position' => null,
        'remuneration' => null,
        'remuneration_interval' => null,
        'remuneration_currency' => null,
        'base_holiday_allocation' => null,
        'sickness_allocation' => null,
        'contact_number' => null,
        'contact_email' => null,
        'started_on' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['user_id', 'first_name', 'last_name', 'dob', 'position', 'remuneration', 'remuneration_interval', 'remuneration_currency', 'base_holiday_allocation', 'sickness_allocation', 'contact_number', 'contact_email', 'started_on']);
});
