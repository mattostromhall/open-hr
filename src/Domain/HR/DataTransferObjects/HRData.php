<?php

namespace Domain\HR\DataTransferObjects;

use Illuminate\Foundation\Auth\User;

class HRData
{
    public function __construct(
        public readonly User $user,
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
