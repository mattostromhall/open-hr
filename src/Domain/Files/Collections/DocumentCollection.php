<?php

namespace Domain\Files\Collections;

use Domain\Files\DataTransferObjects\DocumentListItemData;
use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class DocumentCollection extends Collection
{
    public function toList(): SupportCollection
    {
        return $this->map(
            fn (Document $document) => new DocumentListItemData(
                path: $document->path,
                name: $document->name,
                kind: $document->extension,
                size: $document->size,
                modified: $document->updated_at
            )
        );
    }
}
