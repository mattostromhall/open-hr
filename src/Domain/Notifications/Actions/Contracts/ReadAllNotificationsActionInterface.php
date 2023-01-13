<?php

namespace Domain\Notifications\Actions\Contracts;

use Domain\Notifications\Enums\NotifiableType;

interface ReadAllNotificationsActionInterface
{
    public function execute(int $notifiableId, NotifiableType $notifiableType): bool;
}
