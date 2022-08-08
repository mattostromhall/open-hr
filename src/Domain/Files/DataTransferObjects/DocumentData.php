<?php

namespace Domain\Files\DataTransferObjects;

use Domain\Files\Enums\DocumentableType;

class DocumentData
{
    public function __construct(
        public readonly string $name,
        public readonly string $directory,
        public readonly int $size,
        public readonly string $extension,
        public readonly string $disk,
        public readonly int $documentable_id,
        public readonly DocumentableType $documentable_type
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
