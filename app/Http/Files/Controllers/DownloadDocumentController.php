<?php

namespace App\Http\Files\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\DownloadDocumentAction;
use Domain\Files\Models\Document;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentController extends Controller
{
    public function __invoke(string $path, DownloadDocumentAction $downloadDocument): StreamedResponse
    {
        $document = Document::locatedAt($path)->firstOrFail();

        return $downloadDocument->execute($document);
    }
}
