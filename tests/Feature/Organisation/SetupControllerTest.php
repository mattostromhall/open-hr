<?php

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Organisation;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('returns the setup index on the first stage', function () {
    $this->get(route('setup.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Setup/Index')
                ->where('stage', 1)
        );
});

it('returns the setup index on the second stage', function () {
    Organisation::factory()->create([
        'setup_at' => null
    ]);

    $this->get(route('setup.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Setup/Index')
                ->where('stage', 2)
        );
});

it('redirects away from the setup index if setup is complete', function () {
    Organisation::factory()->create();

    $response = $this->get(route('setup.index'));

    $response->assertStatus(302);
});
