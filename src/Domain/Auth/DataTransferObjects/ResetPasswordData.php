<?php

namespace Domain\Auth\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class ResetPasswordData extends DataTransferObject
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $password_confirmation,
        public readonly string $token
    ) {
        //
    }
}
