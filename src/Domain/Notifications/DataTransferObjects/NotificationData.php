<?php

namespace Domain\Notifications\DataTransferObjects;

class NotificationData
{
    public function __construct(
        public readonly string $body,
        public readonly int $notifiable_id,
        public readonly string $notifiable_type
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
