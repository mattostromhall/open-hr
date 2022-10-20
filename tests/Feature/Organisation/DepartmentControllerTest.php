<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the department index', function () {
    Department::factory()->count(3)->create();

    $this->get(route('department.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Departments/Index')
                ->has('departments', 3)
                ->hasAll([
                    'departments.0.id',
                    'departments.0.name',
                    'departments.0.members_count',
                    'departments.0.head',
                    'departments.0.head.id',
                    'departments.0.head.full_name',
                    'departments.1.id',
                    'departments.1.name',
                    'departments.1.members_count',
                    'departments.1.head',
                    'departments.1.head.id',
                    'departments.1.head.full_name',
                    'departments.2.id',
                    'departments.2.name',
                    'departments.2.members_count',
                    'departments.2.head',
                    'departments.2.head.id',
                    'departments.2.head.full_name'
                ])
        );
});

it('creates a new department when the correct data is provided', function () {
    $response = $this->post(route('department.store'), [
        'name' => 'Development',
        'head_of_department_id' => $this->person->id
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Department created!');
});

it('returns validation errors when creating a new department with incorrect data', function () {
    $response = $this->post(route('department.store'), [
        'name' => null,
        'head_of_department_id' => ''
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['name', 'head_of_department_id']);
});

it('shows the department', function () {
    $department = Department::factory()->create();

    $this->get(route('department.show', ['department' => $department]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Departments/Show')
                ->hasAll([
                    'department',
                    'head',
                    'members'
                ])
        );
});

it('returns the department to edit', function () {
    $department = Department::factory()->create();

    $this->get(route('department.edit', ['department' => $department]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Departments/Edit')
                ->hasAll([
                    'department',
                    'members',
                    'headOptions'
                ])
        );
});

it('updates the department when the correct data is provided', function () {
    $department = Department::factory()->create();

    $response = $this->put(route('department.update', ['department' => $department]), [
        'name' => 'IT & Development',
        'head_of_department_id' => $this->person->id
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Department updated!');
});

it('returns validation errors when updating the department with incorrect data', function () {
    $department = Department::factory()->create();

    $response = $this->put(route('department.update', ['department' => $department]), [
        'name' => null,
        'head_of_department_id' => ''
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['name', 'head_of_department_id']);
});
