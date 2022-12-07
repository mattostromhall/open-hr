<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Models\OneToOne;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('creates a one-to-one when the correct data is provided', function () {
    $this->person->user->assign(Role::PERSON->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);

    $response = $this->post(route('one-to-one.store'), [
        'person_id' => $person->id,
        'manager_id' => $this->person->id,
        'requester_id' => $person->id,
        'person_status' => OneToOneStatus::ACCEPTED->value,
        'manager_status' => OneToOneStatus::INVITED->value,
        'scheduled_at' => now()->addDays(30),
        'recurring' => false,
        'recurrence_interval' => RecurrenceInterval::NEVER->value,
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'One-to-one requested!');
});

it('returns unauthorized if the person does not have permission to create a one-to-one', function () {
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);

    $response = $this->post(route('one-to-one.store'), [
        'person_id' => $person->id,
        'manager_id' => $this->person->id,
        'requester_id' => $person->id,
        'person_status' => OneToOneStatus::ACCEPTED->value,
        'manager_status' => OneToOneStatus::INVITED->value,
        'scheduled_at' => now()->addDays(30),
        'recurring' => false,
        'recurrence_interval' => RecurrenceInterval::NEVER->value,
    ]);

    $response->assertForbidden();
});

it('returns validation errors when creating an one-to-one with incorrect data', function () {
    $response = $this->post(route('one-to-one.store'), [
        'person_id' => null,
        'manager_id' => null,
        'requester_id' => null,
        'person_status' => null,
        'manager_status' => null,
        'scheduled_at' => null,
        'recurring' => null,
        'recurrence_interval' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_id', 'manager_id', 'requester_id', 'person_status', 'manager_status', 'scheduled_at', 'recurring', 'recurrence_interval']);
});

it('shows the one-to-one', function () {
    $this->person->user->assign(Role::PERSON->value);
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $this->get(route('one-to-one.show', ['one_to_one' => $oneToOne]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/OneToOnes/Show')
                ->hasAll([
                    'oneToOne',
                    'requester',
                    'personName',
                    'managerName',
                    'personStatus',
                    'managerStatus',
                    'recurrenceIntervals'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the one-to-one', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $this->get(route('one-to-one.show', ['one_to_one' => $oneToOne]))
        ->assertForbidden();
});

it('returns the one-to-one to edit', function () {
    $this->person->user->assign(Role::PERSON->value);
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $this->get(route('one-to-one.edit', ['one_to_one' => $oneToOne]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/OneToOnes/Edit')
                ->hasAll([
                    'oneToOne',
                    'requester',
                    'personName',
                    'managerName',
                    'personStatus',
                    'managerStatus',
                    'recurrenceIntervals'
                ])
        );
});

it('returns unauthorized when editing if the person does not have permission to update the one-to-one', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $this->get(route('one-to-one.edit', ['one_to_one' => $oneToOne]))
        ->assertForbidden();
});

it('updates the one-to-one when the correct data is provided', function () {
    $this->person->user->assign(Role::PERSON->value);
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->put(route('one-to-one.update', ['one_to_one' => $oneToOne]), [
        'person_status' => OneToOneStatus::ACCEPTED->value,
        'manager_status' => OneToOneStatus::ACCEPTED->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'One-to-one updated!');
});

it('returns unauthorized if the person does not have permission to update the one-to-one', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->put(route('one-to-one.update', ['one_to_one' => $oneToOne]), [
        'person_status' => OneToOneStatus::ACCEPTED->value,
        'manager_status' => OneToOneStatus::ACCEPTED->value
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the one-to-one with incorrect data', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->put(route('one-to-one.update', ['one_to_one' => $oneToOne]), [
        'person_status' => 'not a status',
        'manager_status' => 'not a status',
        'scheduled_at' => 'not a date',
        'recurring' => '',
        'recurrence_interval' => 'not an interval',
        'completed_at' => 'not a date',
        'notes' => 1
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_status', 'manager_status', 'scheduled_at', 'recurring', 'recurrence_interval', 'completed_at', 'notes']);
});

it('deletes the one-to-one', function () {
    $this->person->user->assign(Role::PERSON->value);
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->delete(route('one-to-one.destroy', ['one_to_one' => $oneToOne]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'One-to-one cancelled!');
});

it('returns unauthorized if the person does not have permission to delete the one-to-one', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->delete(route('one-to-one.destroy', ['one_to_one' => $oneToOne]));

    $response->assertForbidden();
});
