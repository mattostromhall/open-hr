<?php

namespace Domain\Auth\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class UserData extends DataTransferObject
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $active = true,
        public readonly bool $reset_required = false,
    ) {
        //
    }
}
