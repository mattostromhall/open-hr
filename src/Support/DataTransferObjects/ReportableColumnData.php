<?php

namespace Support\DataTransferObjects;

class ReportableColumnData extends DataTransferObject
{
    public function __construct(
        public readonly string $display,
        public readonly string $column,
        public readonly string $type
    ) {
        //
    }
}
