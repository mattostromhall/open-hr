<?php

namespace Domain\Files\Actions;

use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentAction
{
    public function execute(Document $document): StreamedResponse
    {
        return Storage::download($document->location);
    }
}
