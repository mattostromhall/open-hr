<?php

namespace Domain\Files\Actions;

use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Illuminate\Support\Collection;

class UploadDocumentsAction
{
    public function __construct(
        protected StoreFileAction $storeFile,
        protected StoreDocumentAction $storeDocument
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
