<?php

use Domain\Absences\Models\Sickness;
use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the sickness management index', function () {
    $this->person->assign(Role::MANAGER);
    $directReport = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);

    Sickness::factory()
        ->count(3)
        ->for($directReport)
        ->create();

    $this->get(route('sickness.manage'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Sickness/Manage')
                ->where('active', 'report')
                ->has('sicknesses', 3)
                ->hasAll([
                    'sicknesses.0.id',
                    'sicknesses.0.start_at',
                    'sicknesses.0.finish_at',
                    'sicknesses.1.id',
                    'sicknesses.1.start_at',
                    'sicknesses.1.finish_at',
                    'sicknesses.2.id',
                    'sicknesses.2.start_at',
                    'sicknesses.2.finish_at',
                ])
        );
});

it('returns unauthorized if the person does not have permission to manage sicknesses', function () {
    $response = $this->get(route('sickness.manage'));

    $response->assertForbidden();
});
