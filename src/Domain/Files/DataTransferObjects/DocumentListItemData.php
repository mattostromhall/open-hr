<?php

namespace Domain\Files\DataTransferObjects;

use Illuminate\Support\Carbon;

class DocumentListItemData
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

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
