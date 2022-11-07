<?php

namespace Domain\Auth\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class AbilityData extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly string $title
    ) {
        //
    }
}
