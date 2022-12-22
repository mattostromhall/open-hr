<?php

use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('updates the users email', function () {
    $this->person->assign(Role::PERSON);
    $this->patch(route('user.update.email', [
        'user' => $this->person->user
    ]), [
        'email' => faker()->safeEmail()
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Email Address successfully updated!');
});

it('allows the update if the same email as the users email is used', function () {
    $this->person->assign(Role::PERSON);
    $this->patch(route('user.update.email', [
        'user' => $this->person->user
    ]), [
        'email' => $this->person->user->email
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Email Address successfully updated!');
});

it('returns unauthorized if the person does not have permission to update the user', function () {
    $this->patch(route('user.update.email', [
        'user' => $this->person->user
    ]), [
        'email' => faker()->safeEmail()
    ])
        ->assertForbidden();
});

it('returns validation errors if the email address is already taken', function () {
    $user = User::factory()->create([
        'email' => 'test@test.com'
    ]);

    $this->patch(route('user.update.email', [
        'user' => $this->person->user
    ]), [
        'email' => 'test@test.com'
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);
});
