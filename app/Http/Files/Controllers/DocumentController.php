<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\StoreDocumentRequest;
use App\Http\Files\ViewModels\DocumentsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\Contracts\DeleteDocumentActionInterface;
use Domain\Files\Actions\Contracts\DocumentableDataFromDocumentPathActionInterface;
use Domain\Files\Actions\Contracts\UploadDocumentsActionInterface;
use Domain\Files\Models\Document;
use Illuminate\Auth\Access\AuthorizationException;
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

        $documentableData = app(DocumentableDataFromDocumentPathActionInterface::class)->execute($prefixedPath);

        return Inertia::render('Files/Documents/Index', new DocumentsViewModel($prefixedPath, $documentableData));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreDocumentRequest $request, UploadDocumentsActionInterface $uploadDocuments): RedirectResponse
    {
        $this->authorize('upload', Document::class);

        $uploadDocuments->execute($request->uploadedDocumentDataCollection());

        return back()->with('flash.success', 'Documents successfully uploaded!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Document $document, DeleteDocumentActionInterface $deleteDocument): RedirectResponse
    {
        $this->authorize('delete', $document);

        $deleted = $deleteDocument->execute($document);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Document, please try again.');
        }

        return back()->with('flash.success', 'Document deleted!');
    }
}
