<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\Actions\Contracts\ReadAllNotificationsActionInterface;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Notifications\Models\Notification;

class ReadAllNotificationsAction implements ReadAllNotificationsActionInterface
{
    public function execute(int $notifiableId, NotifiableType $notifiableType): bool
    {
        return Notification::query()
            ->where('notifiable_id', $notifiableId)
            ->where('notifiable_type', $notifiableType)
            ->update(['read' => true]);
    }
}
