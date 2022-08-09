<?php

namespace Domain\Files\Actions;

use Domain\Files\Models\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentAction
{
    public function execute(Document $document): StreamedResponse
    {
        return Storage::download($document->location);
    }
}