<?php

use Domain\Notifications\Actions\ReadAllNotificationsAction;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Notifications\Models\Notification;
use Domain\People\Models\Person;

it('marks all notifications as read', function () {
    $person = Person::factory()->create();
    $notifications = Notification::factory()
        ->for($person, 'notifiable')
        ->count(5)
        ->create();

    $action = app(ReadAllNotificationsAction::class);

    $notifications->each(
        fn (Notification $notification) =>
        $this->assertFalse($notification->read)
    );

    $action->execute($person->id, NotifiableType::PERSON);

    Notification::query()
        ->get()
        ->each(
            fn (Notification $notification) =>
            $this->assertTrue($notification->read)
        );
});
