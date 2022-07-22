<?php

namespace Domain\Files\Actions;

use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Models\Document;
use Illuminate\Support\Str;

class StoreDocumentAction
{
    public function execute(DocumentData $data): Document
    {
        return Document::create([
            'name' => $data->name,
            'path' => $data->path,
            'disk' => $data->disk,
            'documentable_id' => $data->documentable_id,
            'documentable_type' => $data->documentable_type
        ]);
    }

    protected function fileName($fileData): string
    {
        $name = $fileData->name ?? Str::random(40);

        return $name . '.' . $fileData->file->extension();
    }
}
