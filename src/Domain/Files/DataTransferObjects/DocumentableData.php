<?php

namespace Domain\Files\DataTransferObjects;

use Domain\Files\Enums\DocumentableType;

class DocumentableData
{
    public function __construct(
        public readonly int $id,
        public readonly DocumentableType $type
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
