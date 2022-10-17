<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;
use Silber\Bouncer\BouncerFacade as Bouncer;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();

    Bouncer::role()->firstOrCreate([
        'name' => 'admin',
        'title' => 'Admin',
    ]);

    Bouncer::ability()->firstOrCreate([
        'name' => 'review-holiday',
        'title' => 'Review holiday',
    ]);

    $this->person->user->assign(Role::ADMIN->value);
    $this->person->user->allow(Ability::REVIEW_HOLIDAY->value);

    $this->actingAs($this->person->user);
});

it('shows the holiday to review', function () {
    $holiday = Holiday::factory()->create();

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

it('reviews the holiday request', function () {
    $holiday = Holiday::factory()->create([
        'status' => HolidayStatus::PENDING
    ]);

    $response = $this->patch(route('holiday.review.update', ['holiday' => $holiday]), [
        'status' => HolidayStatus::APPROVED->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Holiday ' . HolidayStatus::APPROVED->statusDisplay() . '.');
});
