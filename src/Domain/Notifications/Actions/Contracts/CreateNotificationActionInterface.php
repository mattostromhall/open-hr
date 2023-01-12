<?php

namespace Domain\Notifications\Actions\Contracts;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;

interface CreateNotificationActionInterface
{
    public function execute(NotificationData $data): Notification;
}
