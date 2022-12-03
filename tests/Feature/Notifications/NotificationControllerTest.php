<?php

use Domain\Auth\Enums\Role;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    $this->organisation = Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('deletes the notification', function () {
    $this->person->user->assign(Role::HEAD_OF_DEPARTMENT->value);
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);
    $notification = Notification::factory()->create([
        'notifiable_id' => $department->id,
        'notifiable_type' => 'department'
    ]);

    $response = $this->delete(route('notifications.destroy', ['notification' => $notification]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Notification deleted!');
});

it('returns unauthorized if the person does not have permission to delete the notification', function () {
    $department = Department::factory()->create([
        'head_of_department_id' => $this->person->id
    ]);
    $notification = Notification::factory()->create([
        'notifiable_id' => $department->id,
        'notifiable_type' => 'department'
    ]);

    $response = $this->delete(route('notifications.destroy', ['notification' => $notification]));

    $response->assertForbidden();
});
