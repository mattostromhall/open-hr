<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\DirectoryRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\CreateDirectoryAction;
use Domain\Files\Actions\DeleteDirectoryAction;
use Illuminate\Http\RedirectResponse;

class DirectoryController extends Controller
{
    public function store(DirectoryRequest $request, CreateDirectoryAction $createDirectory): RedirectResponse
    {
        $createDirectory->execute($request->validated('path'));

        return back()->with('flash.success', 'Folder successfully created!');
    }

    public function destroy(DirectoryRequest $request, DeleteDirectoryAction $deleteDirectory): RedirectResponse
    {
        $deleted = $deleteDirectory->execute($request->validated('path'));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Folder, please try again.');
        }

        return back()->with('flash.success', 'Folder deleted!');
    }
}
