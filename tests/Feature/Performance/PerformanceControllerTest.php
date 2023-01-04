<?php

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

it('returns the performance index', function () {
    $this->get(route('performance.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Index')
                ->where('active', 'request')
                ->hasAll([
                    'manager',
                    'manager.id',
                    'manager.full_name',
                    'upcomingOneToOnes',
                    'previousOneToOnes',
                    'objectives'
                ])
        );
});
