<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\Actions\Contracts\UpdateNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;

class UpdateNotificationAction implements UpdateNotificationActionInterface
{
    public function execute(Notification $notification, NotificationData $data): bool
    {
        return $notification->update([
            'title' => $data->title,
            'body' => $data->body,
            'link' => $data->link,
            'read' => $data->read
        ]);
    }
}
