<?php

namespace Domain\HR\DataTransferObjects;

use Domain\Auth\DataTransferObjects\UserData;

class HRUserData
{
    public function __construct(
        public readonly UserData $user_data,
        public readonly string $contact_number,
        public readonly string $contact_email
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
