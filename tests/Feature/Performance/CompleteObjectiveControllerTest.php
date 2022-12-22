<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('completes the objective', function () {
    $this->person->assign(Role::PERSON);
    $person = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);
    $objective = Objective::factory()->for($person)->create();

    $response = $this->post(route('objective.complete', ['objective' => $objective]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Objective marked as complete!');
});

it('returns unauthorized if the person does not have permission to complete the objective', function () {
    $objective = Objective::factory()->create();

    $response = $this->post(route('objective.complete', ['objective' => $objective]));

    $response->assertForbidden();
});
