<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();

    $this->actingAs($this->person->user);
});

it('syncs the provided roles', function () {
    $this->person->user->assign(Role::MANAGER->value);

    $this->post(route('roles/sync', [
        'user' => $this->person->user
    ]), [
        'roles' => ['admin']
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Roles updated!');
});

it('returns unauthorized if the person does not have permission to sync roles', function () {
    $this->post(route('roles/sync', [
        'user' => $this->person->user
    ]), [
        'roles' => ['admin']
    ])
        ->assertForbidden();
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
