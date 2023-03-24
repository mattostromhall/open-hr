<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Training;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\fake;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the training index', function () {
    Training::factory()->for($this->person)->count(3)->create();
    Training::factory()->for($this->person)->count(3)->create([
        'status' => TrainingStatus::APPROVED
    ]);
    Training::factory()->for($this->person)->count(3)->create([
        'status' => TrainingStatus::APPROVED,
        'state' => TrainingState::STARTED
    ]);
    Training::factory()->for($this->person)->count(3)->create([
        'status' => TrainingStatus::APPROVED,
        'state' => TrainingState::COMPLETED
    ]);

    $this->get(route('training.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Training/Index')
                ->where('active', 'request')
                ->hasAll([
                    'started' => 3,
                    'notStarted' => 3,
                    'completed' => 3,
                    'awaitingApproval' => 3
                ])
        );
});

it('creates a training request when the correct data is provided', function () {
    $this->person->assign(Role::PERSON);
    $response = $this->post(route('training.store'), [
        'person_id' => $this->person->id,
        'status' => TrainingStatus::PENDING->value,
        'state' => TrainingState::TODO->value,
        'description' => fake()->text(),
        'provider' => fake()->company(),
        'cost' => 500,
        'cost_currency' => Currency::GBP->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training request submitted!');
});

it('returns unauthorized if the person does not have permission to create training', function () {
    $response = $this->post(route('training.store'), [
        'person_id' => $this->person->id,
        'status' => TrainingStatus::PENDING->value,
        'state' => TrainingState::TODO->value,
        'description' => fake()->text(),
        'provider' => fake()->company(),
        'cost' => 500,
        'cost_currency' => Currency::GBP->value
    ]);

    $response->assertForbidden();
});

it('returns validation errors when creating an training with incorrect data', function () {
    $response = $this->post(route('training.store'), [
        'person_id' => null,
        'status' => null,
        'state' => null,
        'description' => null,
        'provider' => null,
        'cost' => 'not a number'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_id', 'status', 'state', 'description', 'provider', 'cost', 'cost_currency']);
});

it('shows the training', function () {
    $this->person->assign(Role::PERSON);
    $training = Training::factory()->for($this->person)->create();

    $this->get(route('training.show', ['training' => $training]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Training/Show')
                ->hasAll([
                    'training',
                    'person',
                    'status',
                    'state'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the training', function () {
    $training = Training::factory()->create();

    $this->get(route('training.show', ['training' => $training]))
        ->assertForbidden();
});

it('returns the training to edit', function () {
    $this->person->assign(Role::PERSON);
    $training = Training::factory()->for($this->person)->create();

    $this->get(route('training.edit', ['training' => $training]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Training/Edit')
                ->hasAll([
                    'training',
                    'person',
                    'status',
                    'state'
                ])
        );
});

it('returns unauthorized when editing if the person does not have permission to edit the training', function () {
    $training = Training::factory()->create();

    $this->get(route('training.edit', ['training' => $training]))
        ->assertForbidden();
});

it('updates the training when the correct data is provided', function () {
    $this->person->assign(Role::PERSON);
    $training = Training::factory()->for($this->person)->create();

    $response = $this->put(route('training.update', ['training' => $training]), [
        'status' => TrainingStatus::APPROVED->value,
        'state' => TrainingState::STARTED->value,
        'description' => fake()->text(),
        'provider' => fake()->company(),
        'cost' => 500,
        'cost_currency' => Currency::GBP->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training updated!');
});

it('returns unauthorized if the person does not have permission to update the training', function () {
    $training = Training::factory()->create();

    $response = $this->put(route('training.update', ['training' => $training]), [
        'status' => TrainingStatus::APPROVED->value,
        'state' => TrainingState::STARTED->value,
        'description' => fake()->text(),
        'provider' => fake()->company(),
        'cost' => 500,
        'cost_currency' => Currency::GBP->value
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

it('deletes the training request', function () {
    $this->person->assign(Role::PERSON);
    $training = Training::factory()->for($this->person)->create();

    $response = $this->delete(route('training.destroy', ['training' => $training]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training request cancelled!');
});

it('returns unauthorized if the person does not have permission to delete the training', function () {
    $training = Training::factory()->create();

    $response = $this->delete(route('training.destroy', ['training' => $training]));

    $response->assertForbidden();
});
