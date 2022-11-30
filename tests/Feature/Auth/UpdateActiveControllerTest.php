<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->department = Department::factory()->create();
    $this->person = Person::factory()->create([
        'department_id' => $this->department->id
    ]);
    $this->actingAs($this->department->head->user);
});

it('deactivates the user', function () {
    $this->department->head->user->assign(Role::HEAD_OF_DEPARTMENT->value);

    $this->patch(route('user.update.active', [
        'user' => $this->person->user
    ]), [
        'active' => false
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Deactivated!');
});

it('activates the user', function () {
    $this->department->head->user->assign(Role::HEAD_OF_DEPARTMENT->value);

    $this->patch(route('user.update.active', [
        'user' => $this->person->user
    ]), [
        'active' => true
    ])
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Activated!');
});

it('returns unauthorized if the person does not have permission to update the user', function () {
    $this->patch(route('user.update.active', [
        'user' => $this->person->user
    ]), [
        'active' => true
    ])
        ->assertForbidden();
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
