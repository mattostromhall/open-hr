<?php

namespace Domain\Auth\DataTransferObjects;

class AbilityData
{
    public function __construct(
        public readonly string $name,
        public readonly string $title
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
