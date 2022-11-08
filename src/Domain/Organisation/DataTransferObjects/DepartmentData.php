<?php

namespace Domain\Organisation\DataTransferObjects;

use Domain\People\Models\Person;
use Support\DataTransferObjects\DataTransferObject;

class DepartmentData extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly Person $head_of_department
    ) {
        //
    }
}
