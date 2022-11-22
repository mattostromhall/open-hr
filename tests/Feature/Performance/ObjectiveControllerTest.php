<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('creates an objective when the correct data is provided', function () {
    $response = $this->post(route('objective.store'), [
        'person_id' => $this->person->id,
        'title' => faker()->text(100),
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(30)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Objective successfully created!');
});

it('returns validation errors when creating an objective with incorrect data', function () {
    $response = $this->post(route('objective.store'), [
        'person_id' => null,
        'title' => null,
        'description' => null,
        'due_at' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['person_id', 'title', 'description', 'due_at']);
});

it('shows the objective', function () {
    $objective = Objective::factory()->create();

    $this->get(route('objective.show', ['objective' => $objective]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Objectives/Show')
                ->hasAll([
                    'objective',
                    'tasks',
                    'person'
                ])
        );
});

it('returns the objective to edit', function () {
    $objective = Objective::factory()->create();

    $this->get(route('objective.edit', ['objective' => $objective]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Objectives/Edit')
                ->hasAll([
                    'objective',
                    'tasks',
                    'person'
                ])
        );
});

it('updates the objective when the correct data is provided', function () {
    $objective = Objective::factory()->create();

    $response = $this->put(route('objective.update', ['objective' => $objective]), [
        'title' => faker()->text(100),
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(25),
        'completed_at' => now()->addDays(30)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Objective updated!');
});

it('returns validation errors when updating the objective with incorrect data', function () {
    $objective = Objective::factory()->create();

    $response = $this->put(route('objective.update', ['objective' => $objective]), [
        'title' => 'a',
        'description' => 1,
        'due_at' => 'a date',
        'completed_at' => 'another date'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['title', 'description', 'due_at', 'completed_at']);
});

it('deletes the objective', function () {
    $objective = Objective::factory()->create();

    $response = $this->delete(route('objective.destroy', ['objective' => $objective]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Objective unset!');
});
