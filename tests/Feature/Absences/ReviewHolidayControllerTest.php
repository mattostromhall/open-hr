<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->manager = Person::factory()->create();
    $this->person = Person::factory()->create([
        'manager_id' => $this->manager->id
    ]);

    $this->manager->user->assign(Role::MANAGER->value);
});

it('shows the holiday to review', function () {
    $this->actingAs($this->manager->user);

    $holiday = Holiday::factory()->for($this->person)->create();

    $this->get(route('holiday.review.show', ['holiday' => $holiday]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Holiday/Review')
                ->hasAll([
                    'holiday',
                    'requester',
                    'status',
                    'duration'
                ])
        );
});

it('returns unauthorized when viewing if the person does not have permission to review the holiday', function () {
    $this->actingAs($this->person->user);

    $holiday = Holiday::factory()->for($this->person)->create();

    $this->get(route('holiday.review.show', ['holiday' => $holiday]))
        ->assertForbidden();
});

it('reviews the holiday request', function () {
    $this->actingAs($this->manager->user);

    $holiday = Holiday::factory()->for($this->person)->create([
        'status' => HolidayStatus::PENDING
    ]);

    $response = $this->patch(route('holiday.review.update', ['holiday' => $holiday]), [
        'status' => HolidayStatus::APPROVED->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Holiday ' . HolidayStatus::APPROVED->statusDisplay() . '.');
});

it('returns unauthorized when updating if the person does not have permission to review the holiday', function () {
    $this->actingAs($this->person->user);

    $holiday = Holiday::factory()->for($this->person)->create([
        'status' => HolidayStatus::PENDING
    ]);

    $response = $this->patch(route('holiday.review.update', ['holiday' => $holiday]), [
        'status' => HolidayStatus::APPROVED->value
    ]);

    $response->assertForbidden();
});
