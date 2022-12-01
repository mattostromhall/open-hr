<?php

namespace App\Http\Files\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\DownloadDocumentAction;
use Domain\Files\Models\Document;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(string $path, DownloadDocumentAction $downloadDocument): StreamedResponse
    {
        $document = Document::locatedAt($path)->firstOrFail();

        $this->authorize('download', $document);

        return $downloadDocument->execute($document);
    }
}
