<?php

use Domain\Auth\Enums\Role;
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
    $this->person->assign(Role::MANAGER);

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

it('returns unauthorized if the person does not have permission to create an objective', function () {
    $response = $this->post(route('objective.store'), [
        'person_id' => $this->person->id,
        'title' => faker()->text(100),
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(30)
    ]);

    $response->assertForbidden();
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
    $this->person->assign(Role::PERSON);
    $objective = Objective::factory()->for($this->person)->create();

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

it('returns unauthorized if the person does not have permission to view the objective', function () {
    $objective = Objective::factory()->create();

    $this->get(route('objective.show', ['objective' => $objective]))
        ->assertForbidden();
});

it('returns the objective to edit', function () {
    $this->person->assign(Role::MANAGER);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();

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

it('returns unauthorized when editing if the person does not have permission to update the objective', function () {
    $objective = Objective::factory()->create();

    $this->get(route('objective.edit', ['objective' => $objective]))
        ->assertForbidden();
});

it('updates the objective when the correct data is provided', function () {
    $this->person->assign(Role::MANAGER);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();

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

it('returns unauthorized if the person does not have permission to update the objective', function () {
    $objective = Objective::factory()->create();

    $response = $this->put(route('objective.update', ['objective' => $objective]), [
        'title' => faker()->text(100),
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(25),
        'completed_at' => now()->addDays(30)
    ]);

    $response->assertForbidden();
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
    $this->person->assign(Role::MANAGER);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();

    $response = $this->delete(route('objective.destroy', ['objective' => $objective]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Objective unset!');
});

it('returns unauthorized if the person does not have permission to delete the objective', function () {
    $objective = Objective::factory()->create();

    $response = $this->delete(route('objective.destroy', ['objective' => $objective]));

    $response->assertForbidden();
});
