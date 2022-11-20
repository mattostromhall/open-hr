<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;

class DeleteNotificationAction
{
    public function execute(Notification $notification): bool
    {
        return $notification->delete();
    }
}
