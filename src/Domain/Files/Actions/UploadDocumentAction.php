<?php

namespace Domain\Files\Actions;

use Domain\Files\DataTransferObjects\UploadedDocumentData;

class UploadDocumentAction
{
    public function __construct(
        protected StoreFileAction $storeFile,
        protected StoreDocumentAction $storeDocument
    ) {
        //
    }

    public function execute(UploadedDocumentData $data): void
    {
        $stored = $this->storeFile->execute($data->fileData);

        if (! $stored) {
            return;
        }

        $this->storeDocument->execute($data->documentData);
    }
}
