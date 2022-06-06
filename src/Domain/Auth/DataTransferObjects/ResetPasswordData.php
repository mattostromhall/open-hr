<?php

namespace Domain\Auth\DataTransferObjects;

class ResetPasswordData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $password_confirmation,
        public readonly string $token
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
