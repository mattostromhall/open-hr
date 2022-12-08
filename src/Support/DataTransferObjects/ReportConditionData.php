<?php

namespace Support\DataTransferObjects;

class ReportConditionData extends DataTransferObject
{
    public function __construct(
        public readonly string $column,
        public readonly string $operator,
        public readonly string|int|float|null $value
    ) {
        //
    }
}
