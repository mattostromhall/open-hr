<?php

namespace Domain\Notifications\DataTransferObjects;

use Domain\Notifications\Enums\NotifiableType;
use Support\DataTransferObjects\DataTransferObject;

class NotificationData extends DataTransferObject
{
    public function __construct(
        public readonly string $body,
        public readonly int $notifiable_id,
        public readonly NotifiableType $notifiable_type,
        public readonly ?string $title,
        public readonly ?string $link = null,
        public readonly bool $read = false
    ) {
        //
    }
}
