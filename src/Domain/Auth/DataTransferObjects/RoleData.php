<?php

namespace Domain\Auth\DataTransferObjects;

use Illuminate\Support\Collection;

class RoleData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $title,
        public readonly ?Collection $abilities
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
