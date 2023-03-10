<?php

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the holiday calendar page and data', function () {
    $this->person->assign(Role::ADMIN);

    Holiday::factory()->count(3)->create();

    $this->get(route('holiday.calendar'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Holiday/Calendar')
                ->has('holidayEvents', 3)
                ->hasAll([
                    'holidayEvents.0.title',
                    'holidayEvents.0.start',
                    'holidayEvents.0.end',
                    'holidayEvents.0.color',
                    'holidayEvents.0.classNames',
                    'holidayEvents.0.extendedProps',
                    'holidayEvents.1.title',
                    'holidayEvents.1.start',
                    'holidayEvents.1.end',
                    'holidayEvents.1.color',
                    'holidayEvents.1.classNames',
                    'holidayEvents.1.extendedProps',
                    'holidayEvents.2.title',
                    'holidayEvents.2.start',
                    'holidayEvents.2.end',
                    'holidayEvents.2.color',
                    'holidayEvents.2.classNames',
                    'holidayEvents.2.extendedProps'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the holiday calendar', function () {
    Holiday::factory()->count(3)->create();

    $this->get(route('holiday.calendar'))
        ->assertForbidden();
});
