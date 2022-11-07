<?php

namespace Domain\Files\DataTransferObjects;

use Illuminate\Http\UploadedFile;
use Support\DataTransferObjects\DataTransferObject;

class UploadedFileData extends DataTransferObject
{
    public function __construct(
        public readonly UploadedFile $file,
        public readonly string $path,
        public readonly ?string $name = null,
        public readonly string|array $disk = []
    ) {
        //
    }
}
