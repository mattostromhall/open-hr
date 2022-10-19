<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Silber\Bouncer\BouncerFacade as Bouncer;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('deactivates the user', function () {
    $this->patch(route('user.update.active', [
        'user' => $this->person->user
    ]), [
        'active' => false
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Deactivated!');
});

it('activates the user', function () {
    $this->patch(route('user.update.active', [
        'user' => $this->person->user
    ]), [
        'active' => true
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Activated!');
});

it('returns validation errors if the active state is incorrect', function () {
    $this->patch(route('user.update.active', [
        'user' => $this->person->user
    ]), [
        'active' => ''
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['active']);
});
