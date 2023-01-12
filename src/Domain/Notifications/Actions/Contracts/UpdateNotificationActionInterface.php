<?php

namespace Domain\Notifications\Actions\Contracts;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;

interface UpdateNotificationActionInterface
{
    public function execute(Notification $notification, NotificationData $data): bool;
}
