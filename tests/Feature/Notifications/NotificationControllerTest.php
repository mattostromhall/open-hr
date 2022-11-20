<?php

use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->organisation = Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('deletes the notification', function () {
    $notification = Notification::factory()->create([
        'notifiable_id' => $this->person->id,
        'notifiable_type' => 'person'
    ]);

    $response = $this->delete(route('notifications.destroy', ['notification' => $notification]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Notification deleted!');
});
