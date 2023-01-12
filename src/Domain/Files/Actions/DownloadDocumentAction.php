<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\DownloadDocumentActionInterface;
use Domain\Files\Models\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentAction implements DownloadDocumentActionInterface
{
    public function execute(Document $document): StreamedResponse
    {
        return Storage::download($document->location);
    }
}
