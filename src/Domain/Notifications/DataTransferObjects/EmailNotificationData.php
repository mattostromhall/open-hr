<?php

namespace Domain\Notifications\DataTransferObjects;

class EmailNotificationData
{
    public function __construct(
        public readonly array $recipients,
        public readonly string $subject,
        public readonly string $body,
        public readonly ?string $link = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
