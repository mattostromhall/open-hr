<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\Actions\Contracts\DeleteNotificationActionInterface;
use Domain\Notifications\Models\Notification;

class DeleteNotificationAction implements DeleteNotificationActionInterface
{
    public function execute(Notification $notification): bool
    {
        return $notification->delete();
    }
}
