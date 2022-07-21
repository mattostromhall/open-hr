<?php

namespace Domain\Files\DataTransferObjects;

class UploadedDocumentData
{
    public function __construct(
        public readonly UploadedFileData $fileData,
        public readonly DocumentData $documentData
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
