<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\DeleteFileActionInterface;
use Domain\Files\Models\Document;

class DeleteDocumentAction
{
    public function __construct(protected DeleteFileActionInterface $deleteFile)
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
