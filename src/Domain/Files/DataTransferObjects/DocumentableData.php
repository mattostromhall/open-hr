<?php

namespace Domain\Files\DataTransferObjects;

use Domain\Files\Enums\DocumentableType;
use Support\DataTransferObjects\DataTransferObject;

class DocumentableData extends DataTransferObject
{
    public function __construct(
        public readonly int $id,
        public readonly DocumentableType $type
    ) {
        //
    }
}
