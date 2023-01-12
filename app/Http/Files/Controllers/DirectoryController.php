<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\DirectoryRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\Contracts\CreateDirectoryActionInterface;
use Domain\Files\Actions\Contracts\DeleteDirectoryActionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class DirectoryController extends Controller
{
    public function store(DirectoryRequest $request, CreateDirectoryActionInterface $createDirectory): RedirectResponse
    {
        if (! Gate::allows('create-directory')) {
            abort(403);
        }

        $createDirectory->execute($request->validated('path'));

        return back()->with('flash.success', 'Folder successfully created!');
    }

    public function destroy(DirectoryRequest $request, DeleteDirectoryActionInterface $deleteDirectory): RedirectResponse
    {
        if (! Gate::allows('delete-directory')) {
            abort(403);
        }

        $deleted = $deleteDirectory->execute($request->validated('path'));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Folder, please try again.');
        }

        return back()->with('flash.success', 'Folder deleted!');
    }
}
