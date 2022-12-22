<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('synchronises the department members with the member data provided', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('department.members', ['department' => $department]), [
        'members' => $people->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Department Members updated!');
});

it('returns unauthorized if the person does not have permission to manage the department members', function () {
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('department.members', ['department' => $department]), [
        'members' => $people->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});

it('returns validation errors if the department members data provided is incorrect', function () {
    $department = Department::factory()->create();
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('department.members', ['department' => $department]), [
        'members' => '1,2,3'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['members']);
});
