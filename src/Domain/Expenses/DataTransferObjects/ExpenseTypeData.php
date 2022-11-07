<?php

namespace Domain\Expenses\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class ExpenseTypeData extends DataTransferObject
{
    public function __construct(
        public readonly string $type,
    ) {
        //
    }
}
