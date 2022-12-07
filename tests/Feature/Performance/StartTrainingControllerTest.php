<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Training;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('starts the training', function () {
    $this->person->user->assign(Role::PERSON->value);
    $training = Training::factory()->for($this->person)->create();

    $response = $this->post(route('training.start', ['training' => $training]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training started!');
});

it('returns unauthorized if the person does not have permission to start the training', function () {
    $training = Training::factory()->create();

    $response = $this->post(route('training.start', ['training' => $training]));

    $response->assertForbidden();
});
