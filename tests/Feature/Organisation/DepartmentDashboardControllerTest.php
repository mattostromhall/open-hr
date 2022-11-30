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

it('returns the person dashboard', function () {
    $this->person->user->assign(Role::HEAD_OF_DEPARTMENT->value);
    $this->get(route('dashboard.department'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard/Department')
        );
});

it('returns unauthorized if the person does not have permission to view the department dashboard', function () {
    $this->get(route('dashboard.department'))
        ->assertForbidden();
});
