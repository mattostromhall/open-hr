<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\StoreDocumentRequest;
use App\Http\Files\ViewModels\DocumentsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\DownloadDocumentAction;
use Domain\Files\Actions\StoreDocumentAction;
use Domain\Files\Actions\StoreFileAction;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\Models\Document;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadDocumentController extends Controller
{
    public function __invoke(string $path, DownloadDocumentAction $downloadDocument): StreamedResponse
    {
        $document = Document::wherePath($path)->firstOrFail();

        return $downloadDocument->execute($document);
    }
}
