<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Models\Document;

interface StoreDocumentActionInterface
{
    public function execute(DocumentData $data): Document;
}
