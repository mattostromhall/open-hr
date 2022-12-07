<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Training;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('shows the training request to review', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $training = Training::factory()->for($person)->create();

    $this->get(route('training.review.show', ['training' => $training]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Training/Review')
                ->hasAll([
                    'requester',
                    'training',
                    'status'
                ])
        );
});

it('returns unauthorized when viewing if the person does not have permission to review the training request', function () {
    $training = Training::factory()->create();

    $this->get(route('training.review.show', ['training' => $training]))
        ->assertForbidden();
});

it('updates the training when the correct data is provided', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $training = Training::factory()->for($person)->create();

    $response = $this->patch(route('training.review.update', ['training' => $training]), [
        'status' => TrainingStatus::APPROVED->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training ' . TrainingStatus::APPROVED->statusDisplay() . '.');
});

it('returns unauthorized if the person does not have permission to review the training request', function () {
    $training = Training::factory()->create();

    $response = $this->patch(route('training.review.update', ['training' => $training]), [
        'status' => TrainingStatus::APPROVED->value
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the training with incorrect data', function () {
    $training = Training::factory()->create();

    $response = $this->put(route('training.update', ['training' => $training]), [
        'status' => null,
        'state' => null,
        'description' => null,
        'provider' => null,
        'cost' => 'not a number'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['status', 'state', 'description', 'provider', 'cost', 'cost_currency']);
});
