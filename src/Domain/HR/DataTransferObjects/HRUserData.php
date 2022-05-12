<?php

namespace Domain\HR\DataTransferObjects;

use Domain\Auth\DataTransferObjects\UserData;

class HRUserData
{
    public function __construct(
        public readonly UserData $userData,
        public readonly string $contact_number,
        public readonly string $contact_email
    ) {
        //
    }

    public static function from(array $data): self
    {
        $filtered = collect($data)
            ->only('email', 'password')
            ->toArray();

        $rest = collect($data)
            ->only('contact_number', 'contact_email')
            ->toArray();

        return new self(UserData::from($filtered), ...$rest);
    }
}
