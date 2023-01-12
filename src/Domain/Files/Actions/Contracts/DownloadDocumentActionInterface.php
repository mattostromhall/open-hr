<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\Models\Document;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface DownloadDocumentActionInterface
{
    public function execute(Document $document): StreamedResponse;
}
