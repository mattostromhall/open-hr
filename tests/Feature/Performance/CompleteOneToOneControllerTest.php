<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\OneToOne;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('completes the one-to-one', function () {
    $oneToOne = OneToOne::factory()->create([
        'requester_id' => $this->person->id
    ]);

    $response = $this->post(route('one-to-one.complete', ['one_to_one' => $oneToOne]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'One-to-one marked as complete!');
});
