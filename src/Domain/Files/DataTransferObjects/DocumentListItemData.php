<?php

namespace Domain\Files\DataTransferObjects;

use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;

class DocumentListItemData extends DataTransferObject
{
    public function __construct(
        public readonly string $path,
        public readonly string $name,
        public readonly string $kind,
        public readonly ?int $size = null,
        public readonly ?Carbon $modified = null
    ) {
        //
    }
}
