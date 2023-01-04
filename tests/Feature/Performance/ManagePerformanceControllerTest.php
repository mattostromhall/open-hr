<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create([
        'department_id' => Department::factory()
    ]);
    $this->actingAs($this->person->user);
});

it('returns the performance management index', function () {
    $this->person->assign(Role::MANAGER);

    $this->get(route('performance.manage'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Manage')
                ->where('active', 'schedule')
                ->hasAll([
                    'directReports',
                    'recurrenceIntervals',
                    'upcomingOneToOnes',
                    'previousOneToOnes'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the performance management index', function () {
    $this->get(route('performance.manage'))
        ->assertForbidden();
});
