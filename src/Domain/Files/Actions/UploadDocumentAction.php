<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\StoreDocumentActionInterface;
use Domain\Files\Actions\Contracts\StoreFileActionInterface;
use Domain\Files\DataTransferObjects\UploadedDocumentData;

class UploadDocumentAction
{
    public function __construct(
        protected StoreFileActionInterface $storeFile,
        protected StoreDocumentActionInterface $storeDocument
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
