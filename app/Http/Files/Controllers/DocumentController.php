<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\StoreDocumentRequest;
use App\Http\Files\ViewModels\DocumentsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\StoreDocumentAction;
use Domain\Files\Actions\StoreFileAction;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    public function index(string $path = null): Response
    {
        return Inertia::render('Files/Documents/Index', new DocumentsViewModel('/' . $path));
    }

    public function store(StoreDocumentRequest $request, StoreFileAction $storeFile, StoreDocumentAction $storeDocument): RedirectResponse
    {
        // need to add an action in here to determine whether all documents uploaded, and if not return a message saying which ones failed to upload
        $request->validatedData()->each(function (UploadedDocumentData $data) use ($storeFile, $storeDocument) {
            $stored = $storeFile->execute($data->fileData);

            if (! $stored) {
                return;
            }

            $storeDocument->execute($data->documentData);
        });

        return back()->with('flash.success', 'Documents successfully uploaded!');
    }
}
