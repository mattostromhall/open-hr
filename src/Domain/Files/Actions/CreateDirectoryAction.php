<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Facades\Storage;

class CreateDirectoryAction
{
    public function execute(string $path): bool
    {
        return Storage::makeDirectory($path);
    }
}
