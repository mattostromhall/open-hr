<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\Models\Notification;

class ReadNotificationAction
{
    public function execute(Notification $notification)
    {
        $notification->update([
            'read' => true
        ]);
    }
}
