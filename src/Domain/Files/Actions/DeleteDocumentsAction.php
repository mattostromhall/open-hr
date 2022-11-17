<?php

namespace Domain\Files\Actions;

use Domain\Files\Collections\DocumentCollection;
use Domain\Files\Models\Document;

class DeleteDocumentsAction
{
    public function __construct(protected DeleteDocumentAction $deleteDocument)
    {
        //
    }

    public function execute(DocumentCollection $documents): void
    {
        // need to add an action in here to determine whether all documents were deleted.
        $documents->each(fn (Document $document) => $this->deleteDocument->execute($document));
    }
}
