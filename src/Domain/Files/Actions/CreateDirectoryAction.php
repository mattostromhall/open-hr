<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\CreateDirectoryActionInterface;
use Illuminate\Support\Facades\Storage;

class CreateDirectoryAction implements CreateDirectoryActionInterface
{
    public function execute(string $path): bool
    {
        return Storage::makeDirectory($path);
    }
}
