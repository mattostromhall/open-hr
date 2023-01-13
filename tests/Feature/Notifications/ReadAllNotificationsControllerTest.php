<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Enums\NotifiableType;
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

it('marks all notifications as read', function () {
    Notification::factory()->count(3)->create([
        'notifiable_id' => $this->person->id,
        'notifiable_type' => 'person'
    ]);

    $response = $this->post(route('notifications.all.read'), [
        'notifiable_id' => $this->person->id,
        'notifiable_type' => NotifiableType::PERSON->value
    ]);

    $response->assertStatus(302)
        ->assertSessionHas('flash.success', 'All Notifications marked as read!');
});
