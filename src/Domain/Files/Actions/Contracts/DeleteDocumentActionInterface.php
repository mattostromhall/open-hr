<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\Models\Document;

interface DeleteDocumentActionInterface
{
    public function execute(Document $document): bool;
}
