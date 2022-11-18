<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Facades\Storage;

class DeleteDirectoryAction
{
    public function execute(string $path): bool
    {
        return Storage::deleteDirectory($path);
    }
}
