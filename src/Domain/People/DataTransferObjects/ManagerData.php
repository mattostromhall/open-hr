<?php

namespace Domain\People\DataTransferObjects;

use Domain\People\Models\Person;

class ManagerData
{
    public function __construct(
        public readonly Person $person,
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
