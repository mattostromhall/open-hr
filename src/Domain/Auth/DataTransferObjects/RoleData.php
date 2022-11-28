<?php

namespace Domain\Auth\DataTransferObjects;

use Illuminate\Support\Collection;
use Support\DataTransferObjects\DataTransferObject;

class RoleData extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly string $title,
        public readonly ?Collection $abilities = null
    ) {
        //
    }
}
