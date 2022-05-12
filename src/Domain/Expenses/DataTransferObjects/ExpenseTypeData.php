<?php

namespace Domain\Expenses\DataTransferObjects;

class ExpenseTypeData
{
    public function __construct(
        public readonly string $type,
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
