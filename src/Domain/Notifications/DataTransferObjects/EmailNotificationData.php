<?php

namespace Domain\Notifications\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class EmailNotificationData extends DataTransferObject
{
    public function __construct(
        public readonly array $recipients,
        public readonly string $subject,
        public readonly string $body,
        public readonly ?string $link = null
    ) {
        //
    }
}
