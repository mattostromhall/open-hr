<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\StoreDocumentActionInterface;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Models\Document;

class StoreDocumentAction implements StoreDocumentActionInterface
{
    public function execute(DocumentData $data): Document
    {
        return Document::create([
            'name' => $data->name,
            'directory' => $data->directory,
            'size' => $data->size,
            'extension' => $data->extension,
            'disk' => $data->disk,
            'documentable_id' => $data->documentable_id,
            'documentable_type' => $data->documentable_type
        ]);
    }
}
