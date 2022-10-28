<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Task;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('completes the task', function () {
    $task = Task::factory()->create();

    $response = $this->post(route('task.complete', ['task' => $task]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Task marked as complete!');
});
