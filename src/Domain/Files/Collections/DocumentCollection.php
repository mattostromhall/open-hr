<?php

namespace Domain\Files\Collections;

use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\Collection;

class DocumentCollection extends Collection
{
    public function integrityFilter(string $directory)
    {
        return $this->map(function (Document $document) {
            return $document->name;
        });
    }
}
