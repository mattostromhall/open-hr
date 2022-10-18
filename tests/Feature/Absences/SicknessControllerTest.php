<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Absences\Models\Sickness;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the sickness index', function () {
    Sickness::factory()
        ->count(3)
        ->for($this->person)
        ->create();

    $this->get(route('sickness.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Sickness/Index')
                ->where('active', 'log')
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

it('logs a sickness when the correct data is provided', function () {
    $response = $this->post(route('sickness.store'), [
        'person_id' => $this->person->id,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Sick days logged!');
});

it('returns validation errors when logging a sickness with incorrect data', function () {
    $response = $this->post(route('sickness.store'), [
        'person_id' => '',
        'start_at' => ''
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_id', 'start_at']);
});

it('shows the sickness', function () {
    $sickness = Sickness::factory()->create();

    $this->get(route('sickness.show', ['sickness' => $sickness]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Sickness/Show')
                ->hasAll([
                    'sickness',
                    'logger',
                    'documents'
                ])
        );
});

it('returns the sickness to edit', function () {
    $sickness = Sickness::factory()->create();

    $this->get(route('sickness.edit', ['sickness' => $sickness]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Sickness/Edit')
//                ->has('holiday')
//                ->has('requester')
        );
});

it('updates the holiday request when the correct data is provided', function () {
    $holiday = Holiday::factory()->create([
        'status' => HolidayStatus::PENDING
    ]);

    $response = $this->put(route('holiday.update', ['holiday' => $holiday]), [
        'status' => HolidayStatus::APPROVED->value,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Holiday updated!');
});

it('returns validation errors when update the holiday with incorrect data', function () {
    $holiday = Holiday::factory()->create([
        'status' => HolidayStatus::PENDING
    ]);

    $response = $this->put(route('holiday.update', ['holiday' => $holiday]), [
        'status' => HolidayStatus::APPROVED->value,
        'start_at' => now()->subDay()->toDateString(),
        'finish_at' => now()->subDays(3)->toDateString()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['start_at', 'finish_at']);
});
