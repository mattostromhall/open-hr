<?php

use Domain\Notifications\Actions\DeleteNotificationAction;
use Domain\Notifications\Models\Notification;
use Domain\People\Models\Person;

it('deletes the notification', function () {
    $person = Person::factory()->create();
    $notification = Notification::factory()
        ->for($person, 'notifiable')
        ->create();
    $action = app(DeleteNotificationAction::class);

    $this->assertModelExists($notification);

    $action->execute($notification);

    $this->assertModelMissing($notification);
});
