<?php

namespace Domain\Files\Actions;

use Domain\Files\Models\Document;

class DeleteDocumentAction
{
    public function __construct(protected DeleteFileAction $deleteFile)
    {
        //
    }

    public function execute(Document $document): bool
    {
        $fileDeleted = $this->deleteFile->execute($document->location);

        if ($fileDeleted) {
            return $document->delete();
        }

        return false;
    }
}
