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

it('returns the organisation dashboard', function () {
    $this->person->assign(Role::ADMIN);
    $this->get(route('dashboard.organisation'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard/Organisation')
                ->hasAll([
                    'organisation',
                    'logo',
                    'headCount',
                    'departmentCount',
                    'organisationNotifications'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the organisation dashboard', function () {
    $this->get(route('dashboard.organisation'))
        ->assertForbidden();
});
