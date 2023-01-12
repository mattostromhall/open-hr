<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\Collections\DocumentCollection;

interface DeleteDocumentsActionInterface
{
    public function execute(DocumentCollection $documents): void;
}
