<?php

namespace Domain\Files\DataTransferObjects;

use Support\DataTransferObjects\DataTransferObject;

class UploadedDocumentData extends DataTransferObject
{
    public function __construct(
        public readonly UploadedFileData $fileData,
        public readonly DocumentData $documentData
    ) {
        //
    }
}
