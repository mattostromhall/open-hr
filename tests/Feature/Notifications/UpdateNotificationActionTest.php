<?php

use Domain\Auth\Models\User;
use Domain\Notifications\Actions\UpdateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;
use Domain\People\Models\Person;

it('updates a notification', function () {
    $user = User::factory()->create();
    $person = Person::factory()
        ->for($user)
        ->create();
    $notification = Notification::factory()
        ->for($person, 'notifiable')
        ->create();
    $action = app(UpdateNotificationAction::class);
    $notificationData = new NotificationData(
        body: 'New body',
        notifiable_id: $notification->notifiable_id,
        notifiable_type: $notification->notifiable_type,
        title: 'New title',
        link: null
    );

    $this->assertModelExists($notification);

    $action->execute($notification, $notificationData);

    $this->assertDatabaseHas('notifications', [
        'title' => 'New title',
        'body' => 'New Body',
        'link' => null,
        'read' => false,
        'notifiable_id' => $person->id,
        'notifiable_type' => 'person'
    ]);
});
