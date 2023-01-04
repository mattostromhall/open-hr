<?php

use Domain\Auth\Models\User;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\People\Models\Person;

it('creates a notification', function () {
    $user = User::factory()->create();
    $person = Person::factory()
        ->for($user)
        ->create();
    $action = app(CreateNotificationAction::class);
    $notificationData = new NotificationData(
        body: 'New body',
        notifiable_id: $person->id,
        notifiable_type: NotifiableType::PERSON,
        title: 'New title',
        link: null
    );

    $action->execute($notificationData);

    $this->assertDatabaseHas('notifications', [
        'title' => 'New title',
        'body' => 'New Body',
        'link' => null,
        'read' => false,
        'notifiable_id' => $person->id,
        'notifiable_type' => 'person'
    ]);
});
