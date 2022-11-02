<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('shows the one-to-one invite', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $this->get(route('one-to-one.invite.show', ['one_to_one' => $oneToOne]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/OneToOnes/Invite')
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

it('updates the one-to-one when the correct data is provided', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->patch(route('one-to-one.invite.update', ['one_to_one' => $oneToOne]), [
        'person_status' => OneToOneStatus::ACCEPTED->value,
        'manager_status' => OneToOneStatus::ACCEPTED->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'One-to-one updated!');
});

it('returns validation errors when updating the one-to-one with incorrect data', function () {
    $oneToOne = OneToOne::factory()->create([
        'person_id' => $this->person->id,
        'requester_id' => $this->person->id
    ]);

    $response = $this->patch(route('one-to-one.invite.update', ['one_to_one' => $oneToOne]), [
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
