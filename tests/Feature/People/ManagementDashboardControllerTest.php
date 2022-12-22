<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the management dashboard', function () {
    $this->person->assign(Role::MANAGER);

    $this->get(route('dashboard.management'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard/Management')
        );
});

it('returns unauthorized if the person does not have permission to view the management dashboard', function () {
    $this->get(route('dashboard.management'))
        ->assertForbidden();
});
