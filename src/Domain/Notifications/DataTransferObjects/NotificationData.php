<?php

namespace Domain\Notifications\DataTransferObjects;

class NotificationData
{
    public function __construct(
        public readonly string $body,
        public readonly bool $read,
        public readonly ?string $title,
        public readonly ?string $link
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
