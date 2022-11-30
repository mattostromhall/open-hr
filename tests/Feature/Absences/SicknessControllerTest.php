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
    $this->person->user->assign(Role::PERSON->value);

    $response = $this->post(route('sickness.store'), [
        'person_id' => $this->person->id,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Sick days logged!');
});

it('returns unauthorized if the person does not have permission to create a sickness', function () {
    $response = $this->post(route('sickness.store'), [
        'person_id' => $this->person->id,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response->assertForbidden();
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
    $this->person->user->assign(Role::PERSON->value);
    $sickness = Sickness::factory()->for($this->person)->create();

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

it('returns unauthorized if the person does not have permission to view the sickness', function () {
    $sickness = Sickness::factory()->create();

    $this->get(route('sickness.show', ['sickness' => $sickness]))
        ->assertForbidden();
});

it('returns the sickness to edit', function () {
    $this->person->user->assign(Role::PERSON->value);
    $sickness = Sickness::factory()->for($this->person)->create();

    $this->get(route('sickness.edit', ['sickness' => $sickness]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Sickness/Edit')
                ->has('sickness')
                ->has('logger')
        );
});

it('returns unauthorized when trying to edit if the person does not have permission to update the sickness', function () {
    $sickness = Sickness::factory()->create();
    $this->get(route('sickness.edit', ['sickness' => $sickness]))
        ->assertForbidden();
});

it('updates the sickness when the correct data is provided', function () {
    $this->person->user->assign(Role::PERSON->value);
    $sickness = Sickness::factory()->for($this->person)->create();

    $response = $this->put(route('sickness.update', ['sickness' => $sickness]), [
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Sickness updated!');
});

it('returns unauthorized when updating if the person does not have permission to update the sickness', function () {
    $sickness = Sickness::factory()->create();
    $response = $this->put(route('sickness.update', ['sickness' => $sickness]), [
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDays(2)->toDateString()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the sickness with incorrect data', function () {
    $sickness = Sickness::factory()->create();

    $response = $this->put(route('sickness.update', ['sickness' => $sickness]));

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['start_at']);
});

it('deletes the sickness', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $sickness = Sickness::factory()->for($person)->create();

    $response = $this->delete(route('sickness.destroy', ['sickness' => $sickness]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Sick day cancelled!');
});

it('returns unauthorized if the person does not have permission to delete the sickness', function () {
    $sickness = Sickness::factory()->create();

    $response = $this->delete(route('sickness.destroy', ['sickness' => $sickness]));

    $response->assertForbidden();
});
