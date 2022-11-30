<?php

use Domain\Absences\Enums\HolidayStatus;
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

it('returns the holiday index', function () {
    Holiday::factory()
        ->count(3)
        ->for($this->person)
        ->create();

    Holiday::factory()
        ->count(3)
        ->for($this->person)
        ->create(['status' => HolidayStatus::PENDING]);

    Holiday::factory()
        ->count(3)
        ->for($this->person)
        ->create(['status' => HolidayStatus::REJECTED]);

    $this->get(route('holiday.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Holiday/Index')
                ->where('active', 'request')
                ->has('approved', 3)
                ->hasAll([
                    'approved.0.id',
                    'approved.0.start_at',
                    'approved.0.finish_at',
                    'approved.0.half_day',
                    'approved.0.notes',
                    'approved.1.id',
                    'approved.1.start_at',
                    'approved.1.finish_at',
                    'approved.1.half_day',
                    'approved.1.notes',
                    'approved.2.id',
                    'approved.2.start_at',
                    'approved.2.finish_at',
                    'approved.2.half_day',
                    'approved.2.notes'
                ])
                ->has('pending', 3)
                ->hasAll([
                    'pending.0.id',
                    'pending.0.start_at',
                    'pending.0.finish_at',
                    'pending.0.half_day',
                    'pending.0.notes',
                    'pending.1.id',
                    'pending.1.start_at',
                    'pending.1.finish_at',
                    'pending.1.half_day',
                    'pending.1.notes',
                    'pending.2.id',
                    'pending.2.start_at',
                    'pending.2.finish_at',
                    'pending.2.half_day',
                    'pending.2.notes'
                ])
                ->has('rejected', 3)
                ->hasAll([
                    'rejected.0.id',
                    'rejected.0.start_at',
                    'rejected.0.finish_at',
                    'rejected.0.half_day',
                    'rejected.0.notes',
                    'rejected.1.id',
                    'rejected.1.start_at',
                    'rejected.1.finish_at',
                    'rejected.1.half_day',
                    'rejected.1.notes',
                    'rejected.2.id',
                    'rejected.2.start_at',
                    'rejected.2.finish_at',
                    'rejected.2.half_day',
                    'rejected.2.notes'
                ])
        );
});

it('stores a holiday request when the correct data is provided', function () {
    $this->person->user->assign(Role::PERSON->value);

    $response = $this->post(route('holiday.store'), [
        'person_id' => $this->person->id,
        'status' => HolidayStatus::PENDING->value,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Holiday request submitted!');
});

it('returns unauthorized if the person does not have permission to create holiday', function () {
    $response = $this->post(route('holiday.store'), [
        'person_id' => $this->person->id,
        'status' => HolidayStatus::PENDING->value,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when storing a holiday request with incorrect data', function () {
    $response = $this->post(route('holiday.store'), [
        'person_id' => '',
        'status' => '',
        'start_at' => '',
        'finish_at' => ''
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_id', 'status', 'start_at', 'finish_at']);
});

it('shows the holiday', function () {
    $this->person->user->assign(Role::PERSON->value);
    $holiday = Holiday::factory()->for($this->person)->create();

    $this->get(route('holiday.show', ['holiday' => $holiday]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Holiday/Show')
                ->has('holiday')
                ->has('requester')
        );
});

it('returns unauthorized if the person does not have permission to view the holiday', function () {
    $holiday = Holiday::factory()->create();

    $this->get(route('holiday.show', ['holiday' => $holiday]))
        ->assertForbidden();
});

it('returns the holiday to edit', function () {
    $this->person->user->assign(Role::PERSON->value);
    $holiday = Holiday::factory()->for($this->person)->create();

    $this->get(route('holiday.edit', ['holiday' => $holiday]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Holiday/Edit')
                ->has('holiday')
                ->has('requester')
        );
});

it('returns unauthorized when trying to edit if the person does not have permission to update the holiday', function () {
    $holiday = Holiday::factory()->create();

    $this->get(route('holiday.edit', ['holiday' => $holiday]))
        ->assertForbidden();
});

it('updates the holiday request when the correct data is provided', function () {
    $this->person->user->assign(Role::PERSON->value);
    $holiday = Holiday::factory()
        ->for($this->person)
        ->create([
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

it('returns unauthorized when trying to update if the person does not have permission to update the holiday', function () {
    $holiday = Holiday::factory()->create([
            'status' => HolidayStatus::PENDING
        ]);

    $response = $this->put(route('holiday.update', ['holiday' => $holiday]), [
        'status' => HolidayStatus::APPROVED->value,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the holiday with incorrect data', function () {
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

it('deletes the holiday request', function () {
    $this->person->user->assign(Role::PERSON->value);
    $holiday = Holiday::factory()->for($this->person)->create();

    $response = $this->delete(route('holiday.destroy', ['holiday' => $holiday]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Holiday request cancelled!');
});

it('returns unauthorized if the person does not have permission to delete the holiday', function () {
    $holiday = Holiday::factory()->create();
    $response = $this->delete(route('holiday.destroy', ['holiday' => $holiday]));

    $response->assertForbidden();
});
