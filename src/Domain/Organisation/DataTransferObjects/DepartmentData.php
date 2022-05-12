<?php

namespace Domain\Organisation\DataTransferObjects;

use Domain\People\Models\Person;

class DepartmentData
{
    public function __construct(
        public readonly string $name,
        public readonly Person $head
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
