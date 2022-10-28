<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('completes the objective', function () {
    $objective = Objective::factory()->create();

    $response = $this->post(route('objective.complete', ['objective' => $objective]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Objective marked as complete!');
});
