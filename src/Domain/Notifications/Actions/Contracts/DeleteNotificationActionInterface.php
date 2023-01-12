<?php

namespace Domain\Notifications\Actions\Contracts;

use Domain\Notifications\Models\Notification;

interface DeleteNotificationActionInterface
{
    public function execute(Notification $notification): bool;
}
