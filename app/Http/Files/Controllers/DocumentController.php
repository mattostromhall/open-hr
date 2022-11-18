<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\StoreDocumentRequest;
use App\Http\Files\ViewModels\DocumentsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\DeleteDocumentAction;
use Domain\Files\Actions\DocumentableDataFromDocumentPathAction;
use Domain\Files\Actions\UploadDocumentsAction;
use Domain\Files\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    public function index(string $path = null): Response
    {
        $prefixedPath = '/documents/' . $path;

        abort_unless(Storage::exists($prefixedPath), 404);

        $documentableData = app(DocumentableDataFromDocumentPathAction::class)->execute($prefixedPath);

        return Inertia::render('Files/Documents/Index', new DocumentsViewModel($prefixedPath, $documentableData));
    }

    public function store(StoreDocumentRequest $request, UploadDocumentsAction $uploadDocuments): RedirectResponse
    {
        $uploadDocuments->execute($request->uploadedDocumentDataCollection());

        return back()->with('flash.success', 'Documents successfully uploaded!');
    }

    public function destroy(Document $document, DeleteDocumentAction $deleteDocument): RedirectResponse
    {
        $deleted = $deleteDocument->execute($document);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Document, please try again.');
        }

        return back()->with('flash.success', 'Document deleted!');
    }
}
