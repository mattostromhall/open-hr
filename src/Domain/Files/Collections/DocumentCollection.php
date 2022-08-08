<?php

namespace Domain\Files\Collections;

use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class DocumentCollection extends Collection
{
    public function toFileList(): SupportCollection
    {
        return $this->map(fn (Document $document) => [
            'path' => $document->download_from,
            'name' => $document->name
        ]);
    }
}
