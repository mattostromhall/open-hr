<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;

use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('creates a task for the objective when the correct data is provided', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();

    $response = $this->post(route('task.store', ['objective' => $objective]), [
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(2)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Task successfully created!');
});

it('returns unauthorized if the person does not have permission to create a task', function () {
    $objective = Objective::factory()->create();

    $response = $this->post(route('task.store', ['objective' => $objective]), [
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(2)
    ]);

    $response->assertForbidden();
});

it('returns validation errors when creating a task with incorrect data', function () {
    $objective = Objective::factory()->create();

    $response = $this->post(route('task.store', ['objective' => $objective]), [
        'description' => null,
        'due_at' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['description', 'due_at']);
});

it('updates the task when the correct data is provided', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();
    $task = Task::factory()->for($objective)->create();

    $response = $this->put(route('task.update', ['task' => $task]), [
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(25),
        'completed_at' => now()->addDays(5)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Task successfully updated!');
});

it('returns unauthorized if the person does not have permission to update the task', function () {
    $task = Task::factory()->create();

    $response = $this->put(route('task.update', ['task' => $task]), [
        'description' => faker()->randomHtml(),
        'due_at' => now()->addDays(25),
        'completed_at' => now()->addDays(5)
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the task with incorrect data', function () {
    $task = Task::factory()->create();

    $response = $this->put(route('task.update', ['task' => $task]), [
        'description' => 1,
        'due_at' => 'a date',
        'completed_at' => 'another date'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['description', 'due_at', 'completed_at']);
});

it('deletes the task', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();
    $task = Task::factory()->for($objective)->create();

    $response = $this->delete(route('task.destroy', ['task' => $task]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Task unset!');
});

it('returns unauthorized if the person does not have permission to delete the task', function () {
    $task = Task::factory()->create();

    $response = $this->delete(route('task.destroy', ['task' => $task]));

    $response->assertForbidden();
});
