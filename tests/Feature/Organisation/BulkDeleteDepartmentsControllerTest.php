<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('bulk deletes the selected departments', function () {
    $this->person->assign(Role::ADMIN);
    $departments = Department::factory()->count(3)->create();

    $response = $this->post(route('department.bulk-delete'), [
        'departments' => $departments->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success',  'Selected Departments deleted!');
});

it('returns unauthorized if the person does not have permission to bulk delete departments', function () {
    $departments = Department::factory()->count(3)->create();

    $response = $this->post(route('department.bulk-delete'), [
        'departments' => $departments->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});
