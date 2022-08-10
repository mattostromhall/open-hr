<?php

namespace App\Http\Files\Controllers;

use App\Http\Files\Requests\CreateDirectoryRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\CreateDirectoryAction;
use Illuminate\Http\RedirectResponse;

class DirectoryController extends Controller
{
    public function store(CreateDirectoryRequest $request, CreateDirectoryAction $createDirectory): RedirectResponse
    {
        $createDirectory->execute($request->validated('path'));

        return back()->with('flash.success', 'Folder successfully created!');
    }
}
