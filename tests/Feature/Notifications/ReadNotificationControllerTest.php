<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->organisation = Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('marks a notification as read', function () {
    $notification = Notification::factory()->create([
        'notifiable_id' => $this->person->id,
        'notifiable_type' => 'person'
    ]);

    $response = $this->post(route('notifications.read', ['notification' => $notification]), [
        'read' => true
    ]);

    $response->assertStatus(302);
});

it('marks a notification as unread', function () {
    $notification = Notification::factory()->create([
        'notifiable_id' => $this->person->id,
        'notifiable_type' => 'person'
    ]);

    $response = $this->post(route('notifications.read', ['notification' => $notification]), [
        'read' => false
    ]);

    $response->assertStatus(302);
});
