<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\StoreDocumentActionInterface;
use Domain\Files\Actions\Contracts\StoreFileActionInterface;
use Domain\Files\Actions\Contracts\UploadDocumentsActionInterface;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Illuminate\Support\Collection;

class UploadDocumentsAction implements UploadDocumentsActionInterface
{
    public function __construct(
        protected StoreFileActionInterface $storeFile,
        protected StoreDocumentActionInterface $storeDocument
    ) {
        //
    }

    public function execute(Collection $uploadedDocuments): void
    {
        // need to add an action in here to determine whether all documents uploaded, and if not return a message saying which ones failed to upload
        $uploadedDocuments->each(function (UploadedDocumentData $data) {
            $stored = $this->storeFile->execute($data->fileData);

            if (! $stored) {
                return;
            }

            $this->storeDocument->execute($data->documentData);
        });
    }
}
