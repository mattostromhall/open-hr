<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Training;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('starts the training', function () {
    $training = Training::factory()->create();

    $response = $this->post(route('training.start', ['training' => $training]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training started!');
});