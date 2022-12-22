<?php

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

it('returns the department index', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    Department::factory()->count(3)->create();

    $this->get(route('department.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Departments/Index')
                ->has('departments.data', 3)
                ->hasAll([
                    'departments.data.0.id',
                    'departments.data.0.name',
                    'departments.data.0.members_count',
                    'departments.data.0.head',
                    'departments.data.0.head.id',
                    'departments.data.0.head.full_name',
                    'departments.data.1.id',
                    'departments.data.1.name',
                    'departments.data.1.members_count',
                    'departments.data.1.head',
                    'departments.data.1.head.id',
                    'departments.data.1.head.full_name',
                    'departments.data.2.id',
                    'departments.data.2.name',
                    'departments.data.2.members_count',
                    'departments.data.2.head',
                    'departments.data.2.head.id',
                    'departments.data.2.head.full_name'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the department index', function () {
    Department::factory()->count(3)->create();

    $this->get(route('department.index'))
        ->assertForbidden();
});

it('returns the department create page', function () {
    $this->person->assign(Role::ADMIN);

    $this->get(route('department.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Departments/Create')
                ->has('people')
        );
});

it('returns unauthorized when creating if the person does not have permission to create a department', function () {
    $this->get(route('department.create'))
        ->assertForbidden();
});

it('creates a new department when the correct data is provided', function () {
    $this->person->assign(Role::ADMIN);

    $response = $this->post(route('department.store'), [
        'name' => 'Development',
        'head_of_department_id' => $this->person->id
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Department created!');
});

it('returns unauthorized if the person does not have permission to create a department', function () {
    $response = $this->post(route('department.store'), [
        'name' => 'Development',
        'head_of_department_id' => $this->person->id
    ]);

    $response->assertForbidden();
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
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);

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

it('returns unauthorized if the person does not have permission to view the department', function () {
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);

    $this->get(route('department.show', ['department' => $department]))
        ->assertForbidden();
});

it('returns the department to edit', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);

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

it('returns unauthorized when editing if the person does not have permission to update a department', function () {
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);

    $this->get(route('department.edit', ['department' => $department]))
        ->assertForbidden();
});

it('updates the department when the correct data is provided', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);

    $response = $this->put(route('department.update', ['department' => $department]), [
        'name' => 'IT & Development',
        'head_of_department_id' => $this->person->id
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Department updated!');
});

it('returns unauthorized if the person does not have permission to update a department', function () {
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);

    $response = $this->put(route('department.update', ['department' => $department]), [
        'name' => 'IT & Development',
        'head_of_department_id' => $this->person->id
    ]);

    $response->assertForbidden();
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

it('deletes the department', function () {
    $this->person->assign(Role::ADMIN);
    $department = Department::factory()->create();

    $response = $this->delete(route('department.destroy', ['department' => $department]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Department dissolved!');
});

it('returns unauthorized if the person does not have permission to delete the department', function () {
    $department = Department::factory()->create();

    $response = $this->delete(route('department.destroy', ['department' => $department]));

    $response->assertForbidden();
});
