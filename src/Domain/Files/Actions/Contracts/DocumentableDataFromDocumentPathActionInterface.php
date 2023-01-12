<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\DataTransferObjects\DocumentableData;

interface DocumentableDataFromDocumentPathActionInterface
{
    public function execute(string $path): DocumentableData;
}
