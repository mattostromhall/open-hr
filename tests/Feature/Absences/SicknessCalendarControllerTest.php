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

it('returns the sickness calendar page and data', function () {
    $this->person->assign(Role::ADMIN);

    Sickness::factory()->count(3)->create();

    $this->get(route('sickness.calendar'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Sickness/Calendar')
                ->has('sicknessEvents', 3)
                ->hasAll([
                    'sicknessEvents.0.title',
                    'sicknessEvents.0.start',
                    'sicknessEvents.0.end',
                    'sicknessEvents.0.color',
                    'sicknessEvents.0.classNames',
                    'sicknessEvents.0.extendedProps',
                    'sicknessEvents.1.title',
                    'sicknessEvents.1.start',
                    'sicknessEvents.1.end',
                    'sicknessEvents.1.color',
                    'sicknessEvents.1.classNames',
                    'sicknessEvents.1.extendedProps',
                    'sicknessEvents.2.title',
                    'sicknessEvents.2.start',
                    'sicknessEvents.2.end',
                    'sicknessEvents.2.color',
                    'sicknessEvents.2.classNames',
                    'sicknessEvents.2.extendedProps'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the sickness calendar', function () {
    Sickness::factory()->count(3)->create();

    $this->get(route('sickness.calendar'))
        ->assertForbidden();
});
