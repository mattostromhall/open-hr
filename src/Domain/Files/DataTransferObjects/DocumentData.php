<?php

namespace Domain\Files\DataTransferObjects;

class DocumentData
{
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly string $disk,
        public readonly int $documentable_id,
        public readonly string $documentable_type
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
