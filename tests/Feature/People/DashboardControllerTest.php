<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the person dashboard', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard/Index')
                ->hasAll([
                    'person',
                    'holidayRemaining',
                    'sickDaysRemaining',
                    'organisationNotifications',
                    'objectives'
                ])
        );
});
