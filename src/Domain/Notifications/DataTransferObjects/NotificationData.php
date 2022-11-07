<?php

namespace Domain\Notifications\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class NotificationData extends DataTransferObject
{
    public function __construct(
        public readonly string $body,
        public readonly int $notifiable_id,
        public readonly string $notifiable_type,
        public readonly ?string $title,
        public readonly ?string $link,
        public readonly bool $read = false,
    ) {
        //
    }
}
