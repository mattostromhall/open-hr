<?php

namespace Domain\Auth\DataTransferObjects;

class UserData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $active = true,
        public readonly bool $reset_required = false,
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
