<?php

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Organisation;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\fake;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
});

it('allows access to an active user to a route that has the active middleware applied', function () {
    $person = Person::factory()->create();
    $this->actingAs($person->user);

    $this->get(route('dashboard'))
        ->assertOk();
});

it('redirects to login when an inactive user is accessing a route that requires an active user', function () {
    $user = User::factory()->create([
        'active' => false
    ]);
    Person::factory()->for($user)->create();
    $this->actingAs($user);

    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});
