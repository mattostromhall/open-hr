<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('updates the users password', function () {
    $this->person->user->assign(Role::PERSON->value);
    $this->patch(route('user.update.password', [
        'user' => $this->person->user
    ]), [
        'current_password' => 'password',
        'password' => 'new_password',
        'password_confirmation' => 'new_password'
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Password successfully updated!');
});

it('returns unauthorized if the person does not have permission to update the users password', function () {
    $this->patch(route('user.update.password', [
        'user' => $this->person->user
    ]), [
        'current_password' => 'password',
        'password' => 'new_password',
        'password_confirmation' => 'new_password'
    ])
        ->assertForbidden();
});

it('returns validation errors if the incorrect password data is provided', function () {
    $this->patch(route('user.update.password', [
        'user' => $this->person->user
    ]), [
        'current_password' => '',
        'password' => ''
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['current_password', 'password']);
});
