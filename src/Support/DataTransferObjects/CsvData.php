<?php

namespace Support\DataTransferObjects;

use Illuminate\Support\Collection;

class CsvData extends DataTransferObject
{
    public function __construct(
        public readonly string $path,
        public readonly array $headers,
        public readonly array $records
    ) {
        //
    }
}
