<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;

class CreateNotificationAction
{
    public function execute(NotificationData $data): Notification
    {
        return Notification::create([
            'title' => $data->title,
            'body' => $data->body,
            'notifiable_id' => $data->notifiable_id,
            'notifiable_type' => $data->notifiable_type,
            'link' => $data->link,
            'read' => $data->read
        ]);
    }
}
