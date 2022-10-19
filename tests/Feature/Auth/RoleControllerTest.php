<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Silber\Bouncer\BouncerFacade as Bouncer;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    Bouncer::role()->firstOrCreate([
        'name' => 'admin',
        'title' => 'Admin',
    ]);

    $this->actingAs($this->person->user);
});

it('syncs the provided roles', function () {
    $this->post(route('roles/sync', [
        'user' => $this->person->user
    ]), [
        'roles' => ['admin']
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Roles updated!');
});

it('returns validation errors if the provided roles are incorrect', function () {
    $this->post(route('roles/sync', [
        'user' => $this->person->user
    ]), [
        'roles' => []
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['roles']);
});
