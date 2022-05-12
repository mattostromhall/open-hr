<?php

namespace Domain\Files\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class UploadedFileData
{
    public function __construct(
        public readonly UploadedFile $file,
        public readonly string $path,
        public readonly ?string $name = null,
        public readonly string|array $disk = []
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
